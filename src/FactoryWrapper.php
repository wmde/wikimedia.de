<?php

declare( strict_types = 1 );

namespace App;

use Symfony\Component\HttpFoundation\Request;

class FactoryWrapper {

	private $factory;
	private $onBuildCallbacks = [];

	public function buildFactory( Request $request ) {
		if ( $this->factory !== null ) {
			throw new \RuntimeException( 'Already build' );
		}

		$this->factory = new TopLevelFactory( $request->getLocale() );

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
