<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

class SmokeTest extends EdgeToEdgeTestCase {

	/**
	 * @dataProvider pagePathProvider
	 */
	public function testEachNewsItemIsLinked( string $pagePath ) {
		$response = $this->request( 'GET', $pagePath );

		$this->assertSame(
			200,
			$response->getStatusCode()
		);
	}

	public function pagePathProvider(): iterable {
		yield [ '/' ];
		yield [ '/de' ];
		yield [ '/de/themen' ];
		yield [ '/de/ueber-uns' ];
		yield [ '/de/menschen' ];
		yield [ '/de/impressum' ];
		yield [ '/de/menschen/mitarbeitende' ];
		yield [ '/de/menschen/praesidium' ];

		yield [ '/en' ];
		yield [ '/en/themes' ];
		yield [ '/en/about-us' ];
		yield [ '/en/people' ];
		yield [ '/en/people/staff' ];
		yield [ '/en/people/board' ];
		yield [ '/en/imprint' ];
	}

}