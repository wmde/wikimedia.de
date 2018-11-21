<?php

declare( strict_types = 1 );

namespace App\Controller;

use App\Presenter\NewsItemsTwigPresenter;
use App\TopLevelFactory;
use App\Controller\DatasetPageController;

// phpcs:ignoreFile
class IndexController extends BaseController {

	public function index() {
		$newsPresenter = new NewsItemsTwigPresenter();

		$newsPresenter->present( $this->getFactory()->newNewsRepository()->getLatestNewsItems() );

		$datasets = new DatasetPageController;
		$staffCsv = file_get_contents( $this->container->getParameter( 'kernel.project_dir' ).'/public/files/staff.csv' );

		return $this->render(
			'pages/home.html.twig',
			[
				'news' => $newsPresenter->getViewModel(),
				'staff' => $datasets->peopleData( $staffCsv )
			]
		);
	}

}