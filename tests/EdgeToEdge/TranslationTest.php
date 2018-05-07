<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\TopLevelFactory;
use Symfony\Bundle\FrameworkBundle\Client;

class TranslationTest extends EdgeToEdgeTestCase {

	public function testPageIsEnglishByDefault() {
		$client = $this->createClient();

		$client->request( 'GET', '/' );

		$this->assertPageIsEnglish( $client );
	}

	private function assertPageIsEnglish( Client $client ) {
		$this->assertContains( 'We promote Free', $client->getResponse()->getContent() );
	}

	public function testPageIsInGermanWhenLocaleIsDe() {
		$client = $this->createClient();

		$client->request( 'GET', '/de' );

		$this->assertPageIsGerman( $client );
	}

	private function assertPageIsGerman( Client $client ) {
		$this->assertContains( 'Wir setzen uns für Freies', $client->getResponse()->getContent() );
	}

	public function testPageIsInEnglishWhenLocaleIsEn() {
		$client = $this->createClient();

		$client->request( 'GET', '/en' );

		$this->assertPageIsEnglish( $client );
	}

	public function testWhenLocaleIsEn_linksAreToEnglishPages() {
		$client = $this->createClient();

		$client->request( 'GET', '/en' );

		$this->assertContains( 'href="/en/imprint"', $client->getResponse()->getContent() );
	}

	public function testWhenLocaleIsDe_linksAreToGermanPages() {
		$client = $this->createClient();

		$client->request( 'GET', '/de' );

		$this->assertContains( 'href="/de/impressum"', $client->getResponse()->getContent() );
	}

}