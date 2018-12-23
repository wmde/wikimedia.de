<?php

declare( strict_types = 1 );

namespace App\Controller;

use App\Presenter\NewsItemsTwigPresenter;

// phpcs:ignoreFile
class IndexController extends BaseController {

	public function index() {
		$newsPresenter = new NewsItemsTwigPresenter();

		$newsPresenter->present( $this->getFactory()->newNewsRepository()->getLatestNewsItems() );

		$staffCsv = $this->readFile(
			$this->container->getParameter( 'kernel.project_dir' ) . '/public/files/staff.csv'
		);

		return $this->render(
			'pages/home.html.twig',
			[
				'news' => $newsPresenter->getViewModel(),
				'staff' => ( new DatasetPageController() )->peopleData( $staffCsv, true )
			]
		);
	}

	private function readFile( string $filename ): string {
		if ( !file_exists( $filename ) ) {
			return '';
		}

		return file_get_contents( $filename );
	}

}
