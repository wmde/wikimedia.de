<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

class PageNotFoundTest extends EdgeToEdgeTestCase {

	public function testEachNewsItemIsLinked() {
		$response = $this->request( 'GET', '/de/derp' );

		$this->assertContains(
			'Seite nicht gefunden!',
			$response->getContent()
		);
	}

}