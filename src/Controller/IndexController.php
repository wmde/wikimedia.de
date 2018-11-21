<?php

declare( strict_types = 1 );

namespace App\Controller;

use App\Presenter\NewsItemsTwigPresenter;
use App\TopLevelFactory;

// phpcs:ignoreFile
class IndexController extends BaseController {

	public function index() {
		$newsPresenter = new NewsItemsTwigPresenter();

		$newsPresenter->present( $this->getFactory()->newNewsRepository()->getLatestNewsItems() );

		return $this->render(
			'pages/home.html.twig',
			[
				'news' => $newsPresenter->getViewModel(),
			]
		);
	}

}