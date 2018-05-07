<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\Kernel;
use App\TopLevelFactory;
use FileFetcher\NullFileFetcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;

abstract class EdgeToEdgeTestCase extends TestCase {

	/**
	 * @see Client::request
	 */
	protected function request( string $method, string $uri, array $parameters = array(),
		array $files = array(), array $server = array(), string $content = null, bool $changeHistory = true ): Response {

		$factory = TopLevelFactory::newForRequest( $request );
		$factory->setFileFetcher( new NullFileFetcher() );

		$kernel = new Kernel( 'test', true );
		$kernel->setTopLevelFactory( $factory );

		$kernel->boot();

		/**
		 * @var Client $client
		 */
		$client = $kernel->getContainer()->get( 'test.client' );

		$client->request( ...func_get_args() );

		$request = $client->getRequest();

		$kernel->terminate( $request, $client->getResponse() );

		return $client->getResponse();
	}

}