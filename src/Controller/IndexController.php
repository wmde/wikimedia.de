<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {

	public function index() {
		return $this->render(
			'pages/home.html.twig',
			[
				'news' => [
					[
						'title' => 'Wikimedia live in Karlsruhe',
						'link' => 'https://blog.wikimedia.de/2018/03/16/zentrum-des-freien-wissens-wikimedia-livein-karlsruhe/',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/c2e518.jpg',
						'type_message' => 'news.type.event',
						'link_message' => 'news.type.event.link',
						'text' => 'Wikimedia Deutschland kommt am 26. Mai ins Zentrum für Kunst und Medien nach Karlsruhe. Dort bauen wir für einen Tag ein „Zentrum des Freien Wissens" auf, das auf 300 Quadratmetern unser Engagement für Freies Wissen erlebbar macht.'
					],
					[
						'title' => 'Aus dem Leben von Wikidata',
						'link' => 'https://blog.wikimedia.de/2018/03/21/aus-dem-leben-von-wikidata/',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/a9d2ac.jpg',
						'type_message' => 'news.type.project',
						'link_message' => 'news.type.project.link',
						'text' => 'Ein neues Tool von Wikimedia Deutschland liefert spannende Einblicke in die weltweite Nutzung und Verknüpfung von Freiem Wissen.'
					],
					[
						'title' => 'Das ABC des Freien Wissens „Q = Qualität“',
						'link' => 'https://blog.wikimedia.de/2018/03/16/qualitaetskriterien-und-standards-in-der-offenen-wissenschaft/',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/bfe3bd.jpg',
						'type_message' => 'news.type.event',
						'link_message' => 'news.type.event.link',
						'text' => 'Ist Offene Wissenschaft die bessere Wissenschaft? Und kann die Open-Maxime „Je offener, desto besser“ tatsächlich in der Praxis bestehen? Video und Rückblick zur Veranstaltung jetzt im Blog.'
					],
					[
						'title' => '#NoUploadFilter – Die gefilterte Wikipedia?',
						'link' => 'https://blog.wikimedia.de/2018/03/16/wird-die-wikipedia-bald-vorgefiltert-upload-filter-nein-danke/',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/dd9bf0.jpg',
						'type_message' => 'news.type.initiative',
						'link_message' => 'news.type.initiative.link',
						'text' => 'Unter dem Motto "Community kann Kontext. Filter nicht" kämpft Wikimedia gegen die Einführung von von der EU-Kommission geforderten Upload-Filter. Diese könnten community-betriebenen Projekten wie der Wikipedia große Probleme bereiten.'
					]
				],
				'board' => [
					[
						'name' => 'Tim Moritz Hector',
						'title' => 'board.title.chair',
						'email' => 'tim-moritz.hector@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/317ac5.jpg',
						'message_en' => 'As chair of the board, I am committed to making the Wikimedia world understandable and accessible to all. For me, Free Knowledge means more available knowledge for everybody and thus more educational justice. For me, this is the key to a mature society.',
						'message_de' => 'Als Vorsitzender des Präsidiums engagiere ich mich dafür, die Wikimedia-Welt allen verständlich und zugänglich zu machen. Freies Wissen bedeutet für mich mehr verfügbares Wissen für alle Menschen und dadurch mehr Bildungsgerechtigkeit. Es ist für mich der Schlüssel zu einer mündigen Gesellschaft.',
					],
					[
						'name' => 'Sabria David',
						'title' => 'board.title.vice.chair',
						'email' => 'sabria.david@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/cb9ad0.jpg',
						'message_en' => 'As vice chair, I take care of the strategic affairs of the association and its global role. With the support of the largest of all sources of knowledge, there is also a responsibility for society as a whole. Time and again, I\'m concerned with how we can make the global movement and Wikipedia sustainable.',
						'message_de' => 'Als stellvertretende Vorsitzende kümmere ich mich um die strategischen Angelegenheiten des Vereins und um dessen globale Rolle. Mit der Unterstützung der größten Wissensquelle überhaupt geht eben auch eine gesamtgesellschaftliche Verantwortung einher. Mich beschäftigt immer wieder die Frage, wie wir das Movement und die Wikipedia zukunftsfähig machen können.',
					],
					[
						'name' => 'Kurt Jansson',
						'title' => 'board.title.vice.chair',
						'email' => 'kurt.jansson@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/8a1069.jpg',
						'message_en' => 'I am one of the founders of Wikimedia Deutschland and was chairman of the association for five years. I work in the committees on strategy and finance. The idea of gathering and sharing knowledge brought me to Wikipedia in 2001 and still motivates me to get involved in Free Knowledge.',
						'message_de' => 'Ich bin einer der Gründer von Wikimedia Deutschland und war fünf Jahre lang Vorsitzender des Vereins. Im Präsidium arbeite ich in den Ausschüssen zu Strategie und Finanzen. Die Idee, gemeinsam Wissen zu sammeln und zu teilen, nahm mich schon 2001 für Wikipedia gefangen und motiviert mich bis heute, mich für Freies Wissen zu engagieren.',
					],
					[
						'name' => 'Sebastian Moleski',
						'title' => 'board.title.treasurer',
						'email' => 'sebastian.moleski@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/dfceb6.jpg',
						'message_en' => 'Equality of opportunity is very important to me. That is why, with my work on the board, I would like to contribute to giving people access to knowledge and education. I have been active in Wikipedia since 2004 and work both as treasurer and in the financial supervision of the association.',
						'message_de' => 'Mir ist Chancengerechtigkeit besonders wichtig. Deshalb möchte ich mit meiner Arbeit im Präsidium vor allem dazu beitragen, Menschen den Zugang zu Wissen und Bildung zu ermöglichen. Ich bin seit 2004 in der Wikipedia aktiv und arbeite sowohl als Schatzmeister als auch in der Finanzaufsicht des Vereins.',
					],
					[
						'name' => 'Harald Krichel',
						'title' => 'board.title.at.large',
						'email' => 'harald.krichel@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/c49409.jpg',
						'message_en' => 'Since 2003 I am active as an author, photographer and administrator in Wikipedia. That is why it is particularly important to me to represent the position of the community on the board. I used to be a fan of Brockhaus, but today I think it\'s great to always have knowledge in the bag and above all to contribute to it.',
						'message_de' => 'Seit 2003 bin ich als Autor, Fotograf und Administrator in der Wikipedia aktiv. Deshalb ist es mir besonders wichtig, die Position der Community im Präsidium zu vertreten. Früher war ich Brockhaus-Fan, heute finde ich es großartig, Wissen immer in der Tasche dabei zu haben und vor allem dazu beizutragen.',
					],
					[
						'name' => 'Lukas Mezger',
						'title' => 'board.title.at.large',
						'email' => 'lukas.mezger@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/ba1c9d.jpg',
						'message_en' => 'I am committed to ensuring that Wikimedia Deutschland supports the work of the Wikipedia authors in the best possible way. I believe that more knowledge can make us better people. I also want to get the idea of Free Knowledge shared by as many institutions and organizations as possible.',
						'message_de' => 'Ich setze mich dafür ein, dass Wikimedia Deutschland die Arbeit der ehrenamtlichen Wikipedia-Autorengemeinschaft bestmöglich unterstützt. Denn ich glaube daran, dass mehr Wissen uns zu besseren Menschen machen kann. Außerdem möchte ich erreichen, dass die Idee des Freien Wissens von so vielen Institutionen und Organisationen wie möglich geteilt wird.',
					],
					[
						'name' => 'Johanna Niesyto',
						'title' => 'board.title.at.large',
						'email' => 'johanna.niesyto@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/5902ed.jpg',
						'message_en' => "It is important to me that the association is committed to Free Knowledge for society as a whole. It takes a smart strategy, patience and a lived cooperation culture. According to the saying: 'If you want to go fast, go alone. If you want to go far, go together.'",
						'message_de' => 'Mir liegt es am Herzen, dass sich der Verein gesamtgesellschaftlich für Freies Wissen einsetzt. Dafür braucht es eine kluge Strategie, etwas Geduld und gelebte Kooperationskultur. Ganz nach dem Sprichwort: ‚Wenn du schnell gehen willst, gehe alleine. Wenn du weit gehen willst, gehe mit anderen.‘',
					],
					[
						'name' => 'Peter Dewald',
						'title' => 'board.title.at.large',
						'email' => 'peter.dewald@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/902ed7.jpg',
						'message_en' => 'I am looking back on 35 years of leadership experience and volunteering. For me Wikipedia has created within a few years the basis for free access to extensive knowledge for millions of people. I would like to promote the development of the association and its initiatives on the board.',
						'message_de' => 'Ich blicke auf 35 Jahre Erfahrung als Führungskraft zurück und bin ehrenamtlich engagiert. Für mich hat Wikipedia innerhalb weniger Jahre die Basis für den freien Zugang zu umfangreichem Wissen für Millionen Menschen geschaffen. Im Präsidium möchte ich die Entwicklung des Vereins und seiner Initiativen vorantreiben.',
					],
					[
						'name' => 'Gabriele Theren',
						'title' => 'board.title.at.large',
						'email' => 'gabriele.theren@wikimedia.de',
						'image' => 'https://blog.wikimedia.de/wp-content/uploads/55f19b.jpg',
						'message_en' => 'As a lawyer and head of the social and occupational safety section of the Ministry of Social Affairs of Saxony-Anhalt, I would like to contribute my experience with authorities and organizations to Wikimedia. I am delighted to be able to support the idea of spreading free access to knowledge and to be able to participate practically.',
						'message_de' => 'Als Juristin und Leiterin der Abteilung Soziales und Arbeitsschutz im Sozialministerium Sachsen-Anhalt möchte ich vor allem meine Erfahrungen mit Behörden und Organisationen bei Wikimedia einbringen. Ich freue mich, auf diese Weise die Idee eines sich verbreitenden freien Zugangs zu Wissen zu unterstützen und praktisch mitarbeiten zu können.',
					]
				]
			]
		);
	}

}