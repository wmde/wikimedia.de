<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\FactoryWrapper;
use App\Kernel;
use App\TopLevelFactory;
use Symfony\Component\HttpKernel\Client;

/**
 * Environment state for a single test that makes a web request using BrowserKit\Client
 */
class RequestEnvironment {

	private $kernel;
	private $client;
	private $factoryWrapper;

	public function __construct( Kernel $kernel, Client $client, FactoryWrapper $factoryWrapper ) {
		$this->kernel = $kernel;
		$this->client = $client;
		$this->factoryWrapper = $factoryWrapper;
	}

	public function getKernel(): Kernel {
		return $this->kernel;
	}

	public function getClient(): Client {
		return $this->client;
	}

	public function getFactory(): TopLevelFactory {
		return $this->factoryWrapper->getFactory();
	}

	public function __destruct() {
		$this->kernel->terminate( $this->client->getRequest(), $this->client->getResponse() );
	}

}