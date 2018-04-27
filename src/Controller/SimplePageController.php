<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SimplePageController extends Controller {

	public function index() {
		return $this->render(
			'pages/home.html.twig',
			[
				'board' => [
					[
						'name' => 'Tim Moritz Hector',
						'title' => 'Chair',
						'email' => 'tim-moritz.hector@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/43/317ac5.jpg',
						'message' => 'As chair of the board, I am committed to making the Wikimedia world understandable and accessible to all. For me, Free Knowledge means more available knowledge for everybody and thus more educational justice. For me, this is the key to a mature society.',
					],
					[
						'name' => 'Sabria David',
						'title' => 'Vice Chair',
						'email' => 'sabria.david@wikimedia.de',
						'image' => 'https://www.wikimedia.de/media/fix20/b5/cb9ad0.jpg',
						'message' => 'As vice chair, I take care of the strategic affairs of the association and its global role. With the support of the largest of all sources of knowledge, there is also a responsibility for society as a whole. Time and again, I\'m concerned with how we can make the global movement and Wikipedia sustainable.',
					]
				]
			]
		);
	}

	public function imprint( Request $request ) {
		return $this->render(  $this->getPageTemplatePath( 'imprint', $request->getLocale() ) );
	}

	private function getPageTemplatePath( string $pageName, string $locale ): string {
		return 'pages/' . $pageName . '/' . $pageName . '.' . $locale . '.html.twig';
	}

	public function transparency( Request $request ) {
		return $this->render(  $this->getPageTemplatePath( 'transparency', $request->getLocale() ) );
	}

	public function charter( Request $request ) {
		return $this->render(  $this->getPageTemplatePath( 'charter', $request->getLocale() ) );
	}

}
