<?php

declare( strict_types = 1 );

namespace App;

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Stopwatch\Stopwatch;

class FactoryWrapper {

	private $factory;
	private $onBuildCallbacks = [];
	private $stopwatch;
	private $cache;

	public function __construct( Stopwatch $stopwatch, CacheInterface $cache ) {
		$this->stopwatch = $stopwatch;
		$this->cache = $cache;
	}

	public function buildFactory( Request $request ) {
		if ( $this->factory !== null ) {
			throw new \RuntimeException( 'Already build' );
		}

		$this->factory = new TopLevelFactory(
			$request->getLocale(),
			$this->stopwatch,
			$this->cache
		);

		$this->runOnBuildCallbacks( $this->factory );
	}

	public function onBuild( callable $onBuild ) {
		$this->onBuildCallbacks[] = $onBuild;
	}

	private function runOnBuildCallbacks( TopLevelFactory $factory ) {
		foreach ( $this->onBuildCallbacks as $callback ) {
			$callback( $factory );
		}
	}

	public function getFactory(): TopLevelFactory {
		return $this->factory;
	}

}
