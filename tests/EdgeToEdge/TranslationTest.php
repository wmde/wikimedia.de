<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use Symfony\Component\HttpFoundation\Response;

class TranslationTest extends EdgeToEdgeTestCase {

	public function testPageIsGermanByDefault() {
		$response = $this->request( 'GET', '/' );

		$this->assertPageIsGerman( $response );
	}

	private function assertPageIsEnglish( Response $response ) {
		$this->assertContains( 'We promote Free', $response->getContent() );
	}

	public function testPageIsInGermanWhenLocaleIsDe() {
		$response = $this->request( 'GET', '/de' );

		$this->assertPageIsGerman( $response );
	}

	private function assertPageIsGerman( Response $response ) {
		$this->assertContains( 'Wir setzen uns für Freies', $response->getContent() );
	}

	public function testPageIsInEnglishWhenLocaleIsEn() {
		$response = $this->request( 'GET', '/en' );

		$this->assertPageIsEnglish( $response );
	}

	public function testWhenLocaleIsEn_linksAreToEnglishPages() {
		$response = $this->request( 'GET', '/en' );

		$this->assertContains( 'href="/en/imprint"', $response->getContent() );
	}

	public function testWhenLocaleIsDe_linksAreToGermanPages() {
		$response = $this->request( 'GET', '/de' );

		$this->assertContains( 'href="/de/impressum"', $response->getContent() );
	}

}