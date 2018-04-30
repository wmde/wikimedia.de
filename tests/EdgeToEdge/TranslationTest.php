<?php

namespace App\Tests\EdgeToEdge\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TranslationTest extends WebTestCase {

	public function testPageIsEnglishByDefault() {
		$client = static::createClient();

		$client->request( 'GET', '/' );

		$this->assertPageIsEnglish( $client );
	}

	private function assertPageIsEnglish( Client $client ) {
		$this->assertContains( 'We promote Free', $client->getResponse()->getContent() );
	}

	public function testPageIsInGermanWhenLocaleIsDe() {
		$client = static::createClient();

		$client->request( 'GET', '/de' );

		$this->assertPageIsGerman( $client );
	}

	private function assertPageIsGerman( Client $client ) {
		$this->assertContains( 'Wir setzen uns für Freies', $client->getResponse()->getContent() );
	}


	public function testPageIsInEnglishWhenLocaleIsEn() {
		$client = static::createClient();

		$client->request( 'GET', '/en' );

		$this->assertPageIsEnglish( $client );
	}

	public function testWhenLocaleIsEn_linksAreToEnglishPages() {
		$client = static::createClient();

		$client->request( 'GET', '/en' );

		$this->assertContains( 'href="/en/imprint"', $client->getResponse()->getContent() );
	}

	public function testWhenLocaleIsDe_linksAreToGermanPages() {
		$client = static::createClient();

		$client->request( 'GET', '/de' );

		$this->assertContains( 'href="/de/impressum"', $client->getResponse()->getContent() );
	}

}