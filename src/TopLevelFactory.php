<?php

declare( strict_types = 1 );

namespace App;

use App\DataAccess\NewsRepository;
use App\DataAccess\WordpressApiNewsRepository;
use FileFetcher\FileFetcher;
use FileFetcher\SimpleFileFetcher;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * Framework independent object graph construction
 */
class TopLevelFactory {

	private $locale;
	private $container;

	public function __construct( string $locale ) {
		$this->locale = $locale;
		$this->container = $this->newPimple();
	}

	private function newPimple(): Container {
		$container = new Container();

		$container['file_fetcher'] = function() {
			return new SimpleFileFetcher();
		};

		return $container;
	}

	public function newNewsRepository(): NewsRepository {
		return new WordpressApiNewsRepository( $this->getFileFetcher(), $this->locale );
	}

	private function getFileFetcher(): FileFetcher {
		return $this->container['file_fetcher'];
	}

	public function setFileFetcher( FileFetcher $fileFetcher ) {
		$this->container['file_fetcher'] = $fileFetcher;
	}

}
