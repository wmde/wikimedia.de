<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SimplePageController extends Controller {

	public function index() {
		return $this->render(
			'index.html.twig',
			[
				'controller_name' => 'DefaultController',
			]
		);
	}

	public function such($maw) {
		return $this->render(
			'index.html.twig',
			[
				'controller_name' => 'DefaultController',
			]
		);
	}

}
