/*!
 * Copyright 2017 Atelier Disko. All rights reserved.
 *
 * Use of this source code is governed by the AGPL v3
 * license that can be found in the LICENSE file.
 */

// TODO: move classes into dedicated files and load with https://github.com/symfony/webpack-encore

// A component which has two areas: one for selecting content
// and one for content display. The content area is tethered
// to the selectors.
Fields = class Fields {
	constructor(props = {}) {
		this.props = props;
		this.state = {};
	}

	mount(element) {
		this.element = element;
		this.$el = element.querySelectorAll.bind(element);
		this.$el1 = element.querySelector.bind(element);

		this.bindButtonEvents();
		this.createCounter(this.element);
		this.createNextButton(this.element);
		this.bindNextButtonEvents();
	}

	bindButtonEvents() {
		let buttons = this.$el('.field-button');

		let updateCounter = (name) => {
			this.counterStatus.innerText = this.numberForName(name);
		};

		let handler = (ev) => {
			ev.preventDefault();

			this.clearActiveClasses();

			let name = this.idToName(ev.currentTarget.getAttribute('href').substring(1));
			this.element.classList.add('is-active-' + name);

			// Toggle visibility of texts inside blurb.
			for (let el of this.$el('.fields__text')) {
				el.hidden = this.idToName(el.id) !== name;
			}
			updateCounter(name);
		};

		for (let button of buttons) {
			button.addEventListener('click', handler);
		}
	}

	createCounter(targetEl) {
		let counter = document.createElement('div');
		let status = document.createElement('span');
		let total = document.createElement('span');
		let sep = document.createElement('span');

		counter.classList.add(
			'field-counter',
			'tm--gamma',
			't--caps',
			't--strong'
		);
		counter.setAttribute('aria-live', 'status');

		status.classList.add('field-counter__status');
		status.innerText = 1;

		sep.innerText = ' / ';

		total.innerText = 3;

		counter.appendChild(status);
		counter.appendChild(sep);
		counter.appendChild(total);

		targetEl.insertAdjacentElement('afterbegin', counter);

		this.counterStatus = status;
	}

	createNextButton(targetEl) {
		let button = document.createElement('div');

		button.setAttribute('role', 'button');
		button.setAttribute('aria-controls', 'fields-blurb');
		button.classList.add('fields__next');

		targetEl.insertAdjacentElement('beforeend', button);
	}

	bindNextButtonEvents() {
		let switchClass = (classList) => {
			if (classList.contains('is-active-support')) {
				classList.remove('is-active-support');
				classList.add('is-active-dev');
			} else if (classList.contains('is-active-dev')) {
				classList.remove('is-active-dev');
				classList.add('is-active-know');
			} else if (classList.contains('is-active-know')) {
				classList.remove('is-active-know');
				classList.add('is-active-support');
			}
		};

		let switchText = (classList, textEls) => {
			let name = this.classListToName(classList);

			for (let el of textEls) {
				el.hidden = this.idToName(el.id) !== name;
			}
		};

		let updateCounter = () => {
			this.counterStatus.innerText = this.numberForName(
				this.classListToName(this.element.classList)
			);
		};

		this.$el1('.fields__next').addEventListener('click', () => {
			switchClass(this.element.classList);
			switchText(this.element.classList, this.$el('.fields__text'));
			updateCounter();
		});
	}

	// Extracts the name portion out of an active class:
	// i.e. foo bar is-active-dev -> dev
	classListToName(classList) {
		let splitStr = classList.value.split('-');
		return splitStr[splitStr.length - 1];
	}

	// Extracts the name portio out of an anchor target.
	// i.e. fields-dev -> dev
	idToName(id) {
		return id.substring('fields-'.length);
	}

	// Removes all possible active classes.
	clearActiveClasses() {
		this.element.classList.remove(
			'is-active-dev',
			'is-active-support',
			'is-active-know'
		);
	}

	numberForName(name) {
		return ['support', 'dev', 'know'].indexOf(name) + 1;
	}
};

// A component that implements synchronized animation of several
// elements seperately. The component's basic HTML exists outside.
// It looks like this:
//
// <section class="team">
//   <div class="team__inner">
//     <article class="member">Foo</article>
//     <article class="member">Bar</article>
//     ...
//     <article class="member">Baz</article>
//   </div>
// </section>
//
// The first article element serves as animation stage, all remaining
// articles are hidden by style. They provide all data and preserve
// document semantics.
Team = class Team {
	constructor(props = {}) {
		this.props = props;
		this.state = {};
	}

	mount(element) {
		this.element = element;
		this.$el = element.querySelectorAll.bind(element);
		this.$el1 = element.querySelector.bind(element);

		// Use the first element seen as stage and extract data from others.
		this.stage = this.$el1('.member');
		this.role = this.$el1('.member__role');
		this.text = this.$el1('.member__text');
		this.link = this.$el1('.member__link');
		this.mail = this.$el1('.member__mail');
		this.image = this.$el1('.member__image');

		this.extractData(this.$el('.member'));
		this.createSelect(this.stage);
		this.createList(this.stage);
		this.attachEventHandlers();
	}

	extractData(memberEls) {
		this.state.names = [];

		for (let el of memberEls) {
			let name = el.querySelector('.member__name').innerHTML;
			this.state.names.push(name);

			this.state[name] = {
				image: el.querySelector('.member__image').innerHTML,
				role: el.querySelector('.member__role').innerHTML,
				text: el.querySelector('.member__text').innerHTML,
			};

			// team mail is optional
			this.state[name].mail = '';
			if (el.querySelector('.member__mail')) {
				this.state[name].mail = el.querySelector('.member__mail').innerHTML;
			}
		}
	}

	createSelect(stageEl) {
		let wrapper = document.createElement('div');
		wrapper.classList.add('team__select-wrapper');

		let select = document.createElement('select');
		select.classList.add('team__select', 'ts--alpha', 't--caps');
		select.setAttribute('aria-controls', 'member-stage');

		for (let i = 0; i < this.state.names.length; i++) {
			let option = document.createElement('option');
			option.innerHTML = this.state.names[i];
			if (i === 0) {
				option.selected = true;
			}
			select.appendChild(option);
		}

		wrapper.appendChild(select);
		stageEl.insertAdjacentElement('afterbegin', wrapper);
	}

	createList(stageEl) {
		let ul = document.createElement('ul');
		ul.classList.add('team__list', 'tm--gamma', 't--caps');

		for (let i = 0; i < this.state.names.length; i++) {
			let li = document.createElement('li');

			let a = document.createElement('a');
			a.classList.add('team__list-item');
			a.setAttribute('href', '#member-stage');
			a.setAttribute('aria-controls', '#member-stage');
			a.innerHTML = this.state.names[i];

			if (i === 0) {
				a.classList.add('active');
			}
			li.appendChild(a);
			ul.appendChild(li);
		}
		stageEl.insertAdjacentElement('afterbegin', ul);
	}

	attachEventHandlers() {
		let items = this.$el('.team__list-item');
		let select = this.$el1('.team__select');

		let updateActive = (list, target) => {
			for (let el of list) {
				el.classList.remove('active');
			}
			target.classList.add('active');
		};

		let updateSelected = (selectEl, name) => {
			for (let i = 0; i < selectEl.options.length; i++) {
				if (selectEl.options[i].value === name) {
					selectEl.options[i].selected = true;
					break;
				}
			}
		};

		let updateText = (name) => {
			this.role.innerHTML = this.state[name].role;
			this.text.innerHTML = this.state[name].text;

			if (this.state[name].mail !== '') {
				this.link.hidden = false;
				this.link.setAttribute('href', `mailto:${this.state[name].mail}`);
				this.mail.innerHTML = this.state[name].mail;
			} else {
				this.link.hidden = true;
			}
		};

		let updateImage = (name) => {
			let oldFig = this.$el1('.member__fig');
			this.image.insertAdjacentHTML('afterbegin', this.state[name].image);
			oldFig.classList.add('fadeout');
			window.setTimeout(() => {
				oldFig.remove();
			}, 300);
		};

		let handler = (ev) => {
			ev.preventDefault();

			updateActive(items, ev.target);
			updateText(ev.target.innerHTML);
			updateImage(ev.target.innerHTML);
			updateSelected(select, ev.target.innerHTML);
		};
		for (let el of items) {
			el.addEventListener('click', handler);
		}

		select.addEventListener('change', (ev) => {
			let selectedName;
			/* 'srcElement' is IEs implementation of 'target' */
			let target = ev.target || ev.srcElement;
			for (let i = 0; i < target.length; i++) {
				if (target[i].selected) {
					selectedName = target[i];
					break;
				}
			}
			updateText(selectedName.innerHTML);
			updateImage(selectedName.innerHTML);

			for (let el of items) {
				if (el.innerHTML === selectedName.innerHTML) {
					updateActive(items, el);
				}
			}
		});
	}
};

News = class News {
	constructor(props = {}) {
		this.props = props;
		this.state = {
			current: 0
		};
	}

	mount(element) {
		this.element = element;
		this.$el = element.querySelectorAll.bind(element);
		this.$el1 = element.querySelector.bind(element);

		this.title = this.$el1('.news__title');
		this.teaser = this.$el1('.news__teaser');
		this.text = this.$el1('.news__text');
		this.box = this.$el1('.news__box');
		this.link = this.$el1('.news__link');
		this.counterHook = this.$el1('.news__post');

		this.extractData(this.$el('.news__post'));
		this.createCounter(this.counterHook);
		this.createPreviousImage(this.box);
		this.createNextImage(this.box, false);
		this.createNextImage(this.box, true);
		this.createPreviousButton(this.element);
		this.createNextButton(this.element);
		this.attachEventHandlers();
	}

	extractData(postEls) {
		this.state.data = [];

		for (let el of postEls) {
			let item = {
				image: el.querySelector('.news__image').innerHTML,
				title: el.querySelector('.news__title').innerHTML,
				teaser: el.querySelector('.news__teaser').innerHTML,
				text: el.querySelector('.news__text').innerHTML,
				// need copy, not pointer; hence using 'value' prop
				classes: el.querySelector('.news__box').classList.value,
				link: {
					href: el.querySelector('.news__link').getAttribute('href'),
					innerText: el.querySelector('.news__link').innerText
				}
			};
			this.state.data.push(item);
		}
	}

	createCounter(targetEl) {
		let counter = document.createElement('div');
		let count = document.createElement('span');
		let total = document.createElement('span');
		let sep = document.createElement('span');

		counter.classList.add(
			'news__counter',
			'tm--gamma',
			't--caps',
			't--strong'
		);
		counter.setAttribute('aria-live', 'status');

		count.classList.add('post__count');
		count.innerText = this.state.current + 1;

		sep.innerText = ' / ';

		total.innerText = this.state.data.length;

		counter.appendChild(count);
		counter.appendChild(sep);
		counter.appendChild(total);

		targetEl.insertAdjacentElement('afterbegin', counter);
	}

	createPreviousImage(targetEl) {
		let index = this.state.current - 1;

		let image = document.createElement('div');
		image.classList.add('news__image');
		image.setAttribute('aria-hidden', true);
		image.classList.add('old');
		if (index < 0) {
			index = this.state.data.length -1;
		}
		image.innerHTML = this.state.data[index].image;

		targetEl.insertAdjacentElement('beforeend', image);
	}

	createNextImage(targetEl, isAfterNext) {
		let index = this.state.current + 1;

		let image = document.createElement('div');
		image.classList.add('news__image');
		image.setAttribute('aria-hidden', true);
		if (isAfterNext) {
			index += 1;
			image.classList.add('after-next');
		} else {
			image.classList.add('next');
		}
		if (index >= this.state.data.length) {
			index %= this.state.data.length;
		}
		image.innerHTML = this.state.data[index].image;

		targetEl.insertAdjacentElement('beforeend', image);
	}

	createPreviousButton(targetEl) {
		let button = document.createElement('div');

		button.id = 'previousButton';
		button.classList.add('news__previous');
		button.setAttribute('aria-controls', 'news-stage');
		button.setAttribute('role', 'button');

		targetEl.insertAdjacentElement('beforeend', button);
	}

	createNextButton(targetEl) {
		let button = document.createElement('div');

		button.id = 'nextButton';
		button.classList.add('news__next');
		button.setAttribute('aria-controls', 'news-stage');
		button.setAttribute('role', 'button');

		targetEl.insertAdjacentElement('beforeend', button);
	}

	attachEventHandlers() {
		let previousButton = this.$el1('#previousButton');
		let nextButton = this.$el1('#nextButton');

		let updateCounter = (target) => {
			target.innerHTML = this.state.current + 1;
		};

		let updateText = (i) => {
			this.title.innerHTML = this.state.data[i].title;
			this.teaser.innerHTML = this.state.data[i].teaser;
			this.text.innerHTML = this.state.data[i].text;
			this.box.classList = this.state.data[i].classes;

			let link = this.state.data[i].link;
			this.link.href = link.href;
			this.link.innerText = link.innerText;
			this.link.hidden = link.href === '#';
		};

		let updateImageNext = () => {
			let active = this.$el1('.news__image.active');
			let next = this.$el1('.news__image.next');
			let afterNext = this.$el1('.news__image.after-next');

			this.$el1('.news__image.old').remove();

			active.classList.replace('active', 'old');
			active.setAttribute('aria-hidden', true);

			next.classList.replace('next', 'active');
			next.removeAttribute('aria-hidden');

			afterNext.classList.replace('after-next', 'next');

			this.createNextImage(this.box, true);
		};

		let updateImagePrevious = () => {
			let old = this.$el1('.news__image.old');
			let active = this.$el1('.news__image.active');
			let next = this.$el1('.news__image.next');

			old.classList.replace('old', 'active');
			old.removeAttribute('aria-hidden');

			active.classList.replace('active', 'next');
			active.setAttribute('aria-hidden', true);

			this.$el1('.news__image.after-next').remove();
			next.classList.replace('next', 'after-next');


			this.createPreviousImage(this.box);
		};

		let previous = () => {
			this.state.current--;
			if (this.state.current === -1) {
				this.state.current = this.state.data.length-1;
			}

			updateCounter(this.$el1('.post__count'));
			updateText(this.state.current);
			updateImagePrevious();
		};

		let next = () => {
			this.state.current++;
			if (this.state.current === this.state.data.length) {
				this.state.current = 0;
			}

			updateCounter(this.$el1('.post__count'));
			updateText(this.state.current);
			updateImageNext();
		};

		previousButton.addEventListener('click', previous);
		nextButton.addEventListener('click', next);

		// Add swipe control
		if (Modernizr.touchevents) { // TODO: this might be broken after migrating away from the atelierdisco FW
			let swipeElement = new Hammer(this.element);
			swipeElement.on('swipeleft', next);
			swipeElement.on('swiperight', previous);
		}
	}
};

let $1 = document.querySelector.bind(document);

let fields = new Fields();
let team = new Team();
let news = new News();

fields.mount($1('.fields'));
news.mount($1('.news'));