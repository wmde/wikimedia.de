<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

class NewsSectionTest extends EdgeToEdgeTestCase {

	public function testEachNewsItemIsLinked() {
		$response = $this->request( 'GET', '/de' );

		$this->assertContains(
			'https&#x3A;&#x2F;&#x2F;blog.wikimedia.de&#x2F;2018&#x2F;05&#x2F;19&#x2F;freies-wissen-weltweit-die-gesichter-hinter-wikimedia-teil-3&#x2F;',
			$response->getContent()
		);

		$this->assertContains(
			'https&#x3A;&#x2F;&#x2F;blog.wikimedia.de&#x2F;2018&#x2F;05&#x2F;17&#x2F;wiki-loves-jule-verne&#x2F;',
			$response->getContent()
		);
	}

}