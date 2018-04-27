/*!
 * Copyright 2017 Atelier Disko. All rights reserved.
 *
 * Use of this source code is governed by the AGPL v3
 * license that can be found in the LICENSE file.
 */


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

let $1 = document.querySelector.bind(document);

let fields = new Fields();
let team = new Team();

fields.mount($1('.fields'));
team.mount($1('.team'));