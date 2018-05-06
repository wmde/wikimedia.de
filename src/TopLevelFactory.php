<?php

declare( strict_types = 1 );

namespace App;

use App\DataAccess\NewsRepository;
use App\DataAccess\WordpressApiNewsRepository;
use FileFetcher\FileFetcher;
use FileFetcher\SimpleFileFetcher;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;

class TopLevelFactory {

	private $locale;
	private $container;

	/**
	 * TODO: move this framework bound function elsewhere
	 * Unless we make this factory depend on the framework for easier access to general config
	 */
	public static function newForRequest( Request $request ): self {
		return new self( $request->getLocale() );
	}

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
		// TODO: decorate with ErrorLoggingFileFetcher
		return new WordpressApiNewsRepository( $this->getFileFetcher(), $this->locale );
	}

	private function getFileFetcher(): FileFetcher {
		return $this->container['file_fetcher'];
	}

	public function setFileFetcher( FileFetcher $fileFetcher ) {
		$this->container['file_fetcher'] = $fileFetcher;
	}

}
