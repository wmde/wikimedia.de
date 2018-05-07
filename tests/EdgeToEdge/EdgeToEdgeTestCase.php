<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\TopLevelFactory;
use FileFetcher\NullFileFetcher;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Client;

abstract class EdgeToEdgeTestCase extends KernelTestCase {

	protected function createClient(array $options = array()): Client {
		static::ensureKernelShutdown();

		static::$kernel = static::createKernel($options);

		$factory = new TopLevelFactory( 'en' );
		$factory->setFileFetcher( new NullFileFetcher() );
		static::$kernel->setTopLevelFactory( $factory );

		static::$kernel->boot();

		$client = static::$kernel->getContainer()->get('test.client');

		return $client;
	}

}