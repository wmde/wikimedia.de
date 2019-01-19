<?php

declare( strict_types = 1 );

namespace App;

use App\DataAccess\NewsRepository;
use App\DataAccess\WordpressApiNewsRepository;
use FileFetcher\FileFetcher;
use FileFetcher\SimpleFileFetcher;
use FileFetcher\Stopwatch\Factory as StopwatchFactory;
use FileFetcher\Cache\Factory as CacheFactory;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Framework independent object graph construction
 */
class TopLevelFactory {

	private $locale;
	private $container = [];

	public function __construct( string $locale, Stopwatch $stopwatch, CacheInterface $cache ) {
		$this->locale = $locale;
		$this->container[Stopwatch::class] = $stopwatch;
		$this->container[CacheInterface::class] = $cache;
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
		return new WordpressApiNewsRepository(
			$this->getStopwatchFileFetcher(),
			$this->locale
		);
	}

	public function setFileFetcher( FileFetcher $fileFetcher ) {
		$this->container[FileFetcher::class] = $fileFetcher;
	}

	private function getStopwatchFileFetcher(): FileFetcher {
		return $this->getSharedService(
			FileFetcher::class,
			function() {
				return ( new StopwatchFactory() )->newStopwatchFetcher(
					$this->newCachingFileFetcher(),
					$this->getStopwatch()
				);
			}
		);
	}

	private function newCachingFileFetcher(): FileFetcher {
		return ( new CacheFactory() )->newCachingFetcher(
			new SimpleFileFetcher(),
			$this->getCache(),
			60
		);
	}

	private function getStopwatch(): Stopwatch {
		return $this->container[Stopwatch::class];
	}

	private function getCache(): CacheInterface {
		return $this->container[CacheInterface::class];
	}

}
