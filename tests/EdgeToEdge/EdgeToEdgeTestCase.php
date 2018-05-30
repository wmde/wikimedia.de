<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\FactoryWrapper;
use App\Kernel;
use App\Tests\TestData;
use App\TopLevelFactory;
use FileFetcher\NullFileFetcher;
use FileFetcher\SimpleFileFetcher;
use FileFetcher\StubFileFetcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;

abstract class EdgeToEdgeTestCase extends TestCase {

	protected function createEnvironment(): RequestEnvironment {
		$kernel = new Kernel( 'test', true );

		$kernel->boot();

		/**
		 * @var FactoryWrapper $wrapper
		 */
		$wrapper = $kernel->getContainer()->get( FactoryWrapper::class );

		$wrapper->onBuild( function( TopLevelFactory $factory ) {
			// TODO: avoid disk read for every test
			$factory->setFileFetcher( new StubFileFetcher( TestData::getFileContents( 'blog/posts-six-valid.json' ) ) );
		} );

		/**
		 * @var Client $client
		 */
		$client = $kernel->getContainer()->get( 'test.client' );

		return new RequestEnvironment( $kernel, $client, $wrapper );
	}

	/**
	 * @see Client::request
	 */
	protected function request( string $method, string $uri, array $parameters = [],
		array $files = [], array $server = [], string $content = null ): Response {

		$environment = $this->createEnvironment();
		$environment->getClient()->request( ...func_get_args() );

		return $environment->getClient()->getResponse();
	}

}
