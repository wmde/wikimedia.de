<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SimplePageController extends Controller {

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
