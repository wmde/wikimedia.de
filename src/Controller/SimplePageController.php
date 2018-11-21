<?php

declare( strict_types = 1 );

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SimplePageController extends Controller {

	public function imprint( Request $request ): Response {
		return $this->render( $this->getPageTemplatePath( 'imprint', $request->getLocale() ) );
	}

	private function getPageTemplatePath( string $pageName, string $locale ): string {
		return 'pages/' . $pageName . '/' . $pageName . '.' . $locale . '.html.twig';
	}

	public function transparency( Request $request ): Response {
		return $this->render( $this->getPageTemplatePath( 'transparency', $request->getLocale() ) );
	}

	public function charter( Request $request ): Response {
		return $this->render( $this->getPageTemplatePath( 'charter', $request->getLocale() ) );
	}

	public function about( Request $request ): Response {
		return $this->render( $this->getPageTemplatePath( 'about', $request->getLocale() ) );
	}

	public function people( Request $request ): Response {
		// TODO: either rename this `overview` or move to page root folder
		// TODO: this shouldn't call multilanguage files but rather be handled via system translation
		return $this->render( $this->getPageTemplatePath( 'people', $request->getLocale() ) );
	}

}
