<?php

declare( strict_types = 1 );

namespace App;

use App\DataAccess\NewsRepository;
use App\DataAccess\WordpressApiNewsRepository;
use FileFetcher\FileFetcher;
use FileFetcher\SimpleFileFetcher;

/**
 * Framework independent object graph construction
 */
class TopLevelFactory {

	private $locale;
	private $container = [];

	public function __construct( string $locale ) {
		$this->locale = $locale;
	}

	/**
	 * @return mixed
	 */
	private function getSharedService( string $serviceName, callable $constructionFunction ) {
		if ( !array_key_exists( $serviceName, $this->container ) ) {
			$this->container[$serviceName] = $constructionFunction();
		}

		return $this->container[$serviceName];
	}

	public function newNewsRepository(): NewsRepository {
		return new WordpressApiNewsRepository( $this->getFileFetcher(), $this->locale );
	}

	private function getFileFetcher(): FileFetcher {
		return $this->getSharedService(
			FileFetcher::class,
			function() {
				return new SimpleFileFetcher();
			}
		);
	}

	public function setFileFetcher( FileFetcher $fileFetcher ) {
		$this->container[FileFetcher::class] = $fileFetcher;
	}

}
