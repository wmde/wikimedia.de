<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SimplePageController extends Controller {

	public function index() {
		return $this->render( 'index.html.twig' );
	}

	public function such() {
		return $this->render( 'index.html.twig' );
	}

}
