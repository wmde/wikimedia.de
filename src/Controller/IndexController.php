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

		// thanks to Stackoverflow user Sarfraz we quickly got the concept of dynamic classes, see:
		// https://stackoverflow.com/a/2350948
		$datasets = new DatasetPageController;
		function readFile( $filename ) {
			if (! file_exists( $filename ) ) { return ''; } // no file? return empty string
			return file_get_contents( $filename );
		}
		$staffCsv = readFile( $this->container->getParameter( 'kernel.project_dir' ).'/public/files/staff.csv' );

		return $this->render(
			'pages/home.html.twig',
			[
				'news' => $newsPresenter->getViewModel(),
				'staff' => $datasets->peopleData( $staffCsv )
			]
		);
	}

}