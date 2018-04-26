<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SimplePageController extends Controller {

	public function index() {
		return $this->render( 'index.html.twig' );
	}

	public function imprint( Request $request ) {
		return $this->render(  $this->getPageTemplatePath( 'imprint', $request->getLocale() ) );
	}

	private function getPageTemplatePath( string $pageName, string $locale ): string {
		return 'pages/' . $pageName . '/' . $pageName . '.' . $locale . '.twig.html';
	}

	public function transparency( Request $request ) {
		return $this->render(  $this->getPageTemplatePath( 'transparency', $request->getLocale() ) );
	}

	public function charter( Request $request ) {
		return $this->render(  $this->getPageTemplatePath( 'charter', $request->getLocale() ) );
	}

}
