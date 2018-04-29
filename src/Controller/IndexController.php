<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {

	public function index() {
		return $this->render(
			'pages/home.html.twig',
			[
				'board' => [
					[
						'name' => 'Tim Moritz Hector',
						'title' => 'board.title.chair',
						'email' => 'tim-moritz.hector@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/43/317ac5.jpg',
						'message' => 'As chair of the board, I am committed to making the Wikimedia world understandable and accessible to all. For me, Free Knowledge means more available knowledge for everybody and thus more educational justice. For me, this is the key to a mature society.',
					],
					[
						'name' => 'Sabria David',
						'title' => 'board.title.vice.chair',
						'email' => 'sabria.david@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/b5/cb9ad0.jpg',
						'message' => 'As vice chair, I take care of the strategic affairs of the association and its global role. With the support of the largest of all sources of knowledge, there is also a responsibility for society as a whole. Time and again, I\'m concerned with how we can make the global movement and Wikipedia sustainable.',
					],
					[
						'name' => 'Kurt Jansson',
						'title' => 'board.title.vice.chair',
						'email' => 'kurt.jansson@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/be/8a1069.jpg',
						'message' => 'I am one of the founders of Wikimedia Deutschland and was chairman of the association for five years. I work in the committees on strategy and finance. The idea of gathering and sharing knowledge brought me to Wikipedia in 2001 and still motivates me to get involved in Free Knowledge.',
					],
					[
						'name' => 'Sebastian Moleski',
						'title' => 'board.title.treasurer',
						'email' => 'sebastian.moleski@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/c1/dfceb6.jpg',
						'message' => 'Equality of opportunity is very important to me. That is why, with my work on the board, I would like to contribute to giving people access to knowledge and education. I have been active in Wikipedia since 2004 and work both as treasurer and in the financial supervision of the association.',
					],
					[
						'name' => 'Harald Krichel',
						'title' => 'board.title.at.large',
						'email' => 'harald.krichel@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/fd/c49409.jpg',
						'message' => 'Since 2003 I am active as an author, photographer and administrator in Wikipedia. That is why it is particularly important to me to represent the position of the community on the board. I used to be a fan of Brockhaus, but today I think it\'s great to always have knowledge in the bag and above all to contribute to it.',
					],
					[
						'name' => 'Lukas Mezger',
						'title' => 'board.title.at.large',
						'email' => 'lukas.mezger@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/79/ba1c9d.jpg',
						'message' => 'I am committed to ensuring that Wikimedia Deutschland supports the work of the Wikipedia authors in the best possible way. I believe that more knowledge can make us better people. I also want to get the idea of Free Knowledge shared by as many institutions and organizations as possible.',
					],
					[
						'name' => 'Johanna Niesyto ',
						'title' => 'board.title.at.large',
						'email' => 'johanna.niesyto@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/96/5902ed.jpg',
						'message' => "It is important to me that the association is committed to Free Knowledge for society as a whole. It takes a smart strategy, patience and a lived cooperation culture. According to the saying: 'If you want to go fast, go alone. If you want to go far, go together.'",
					],
					[
						'name' => 'Peter Dewald',
						'title' => 'board.title.at.large',
						'email' => 'peter.dewald@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/65/902ed7.jpg',
						'message' => 'I am looking back on 35 years of leadership experience and volunteering. For me Wikipedia has created within a few years the basis for free access to extensive knowledge for millions of people. I would like to promote the development of the association and its initiatives on the board.',
					],
					[
						'name' => 'Gabriele Theren',
						'title' => 'board.title.at.large',
						'email' => 'gabriele.theren@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/55/55f19b.jpg',
						'message' => 'As a lawyer and head of the social and occupational safety section of the Ministry of Social Affairs of Saxony-Anhalt, I would like to contribute my experience with authorities and organizations to Wikimedia. I am delighted to be able to support the idea of spreading free access to knowledge and to be able to participate practically.',
					]
				],
				'news' => [
					[
						'title' => 'Wikimedia live in Karlsruhe',
						'link' => 'https://blog.wikimedia.de/2018/03/16/zentrum-des-freien-wissens-wikimedia-livein-karlsruhe/',
						'image' => 'https://www.wikimedia.de/media/fix20/30/c2e518.jpg',
						'type_message' => 'news.type.event',
						'link_message' => 'news.type.event.link',
						'text' => 'Wikimedia Deutschland kommt am 26. Mai ins Zentrum für Kunst und Medien nach Karlsruhe. Dort bauen wir für einen Tag ein „Zentrum des Freien Wissens" auf, das auf 300 Quadratmetern unser Engagement für Freies Wissen erlebbar macht.'
					],
					[
						'title' => 'Aus dem Leben von Wikidata',
						'link' => 'https://blog.wikimedia.de/2018/03/21/aus-dem-leben-von-wikidata/',
						'image' => 'https://www.wikimedia.de/media/fix20/ee/a9d2ac.jpg',
						'type_message' => 'news.type.project',
						'link_message' => 'news.type.project.link',
						'text' => 'Ein neues Tool von Wikimedia Deutschland liefert spannende Einblicke in die weltweite Nutzung und Verknüpfung von Freiem Wissen.'
					],
					[
						'title' => 'Das ABC des Freien Wissens „Q = Qualität“',
						'link' => 'https://blog.wikimedia.de/2018/03/16/qualitaetskriterien-und-standards-in-der-offenen-wissenschaft/',
						'image' => 'https://www.wikimedia.de/media/fix20/79/bfe3bd.jpg',
						'type_message' => 'news.type.event',
						'link_message' => 'news.type.event.link',
						'text' => 'Ist Offene Wissenschaft die bessere Wissenschaft? Und kann die Open-Maxime „Je offener, desto besser“ tatsächlich in der Praxis bestehen? Video und Rückblick zur Veranstaltung jetzt im Blog.'
					],
					[
						'title' => '#NoUploadFilter – Die gefilterte Wikipedia?',
						'link' => 'https://blog.wikimedia.de/2018/03/16/wird-die-wikipedia-bald-vorgefiltert-upload-filter-nein-danke/',
						'image' => 'https://www.wikimedia.de/media/fix20/20/dd9bf0.jpg',
						'type_message' => 'news.type.initiative',
						'link_message' => 'news.type.initiative.link',
						'text' => 'Unter dem Motto "Community kann Kontext. Filter nicht" kämpft Wikimedia gegen die Einführung von von der EU-Kommission geforderten Upload-Filter. Diese könnten community-betriebenen Projekten wie der Wikipedia große Probleme bereiten.'
					]
				]
			]
		);
	}

}
