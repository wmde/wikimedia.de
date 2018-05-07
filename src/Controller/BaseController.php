<?php

declare( strict_types = 1 );

namespace App\Controller;

use App\FactoryWrapper;
use App\TopLevelFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller {

	private $wrapper;
	private $factory;

	public function __construct( FactoryWrapper $wrapper ) {
		$this->wrapper = $wrapper;
	}

	protected function getFactory(): TopLevelFactory {
		if ( $this->factory === null ) {
			$this->factory = $this->newFactory();
		}

		return $this->factory;
	}

	private function newFactory(): TopLevelFactory {
		$this->wrapper->buildFactory( $this->container->get( 'request_stack' )->getCurrentRequest() );
		return $this->wrapper->getFactory();
	}

}