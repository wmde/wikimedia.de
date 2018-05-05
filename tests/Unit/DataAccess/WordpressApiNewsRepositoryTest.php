<?php

declare( strict_types = 1 );

namespace App\Tests\Unit\DataAccess;

use App\DataAccess\NewsItem;
use App\DataAccess\WordpressApiNewsRepository;
use App\Tests\TestData;
use FileFetcher\FileFetcher;
use FileFetcher\StubFileFetcher;
use FileFetcher\ThrowingFileFetcher;
use PHPUnit\Framework\TestCase;

/**
 * @covers WordpressApiNewsRepository
 */
class WordpressApiNewsRepositoryTest extends TestCase {

	public function testWhenFileFetcherThrowsException_emptyArrayIsReturned() {
		$repo = new WordpressApiNewsRepository( new ThrowingFileFetcher() );

		$this->assertSame( [], $repo->getLatestNewsItems() );
	}

	public function testWhenJsonIsValid_newsItemsAreReturned() {
		$repo = new WordpressApiNewsRepository( $this->newStubFetcher( 'posts-several-english.json' ) );

		$items = $repo->getLatestNewsItems();

		$this->assertContainsOnlyInstancesOf( NewsItem::class, $items );
		$this->assertCount( 10, $items );
	}

	private function newStubFetcher( string $fileName ): FileFetcher {
		return new StubFileFetcher( TestData::getFileContents( 'blog/' . $fileName ) );
	}

	public function testWhenJsonIsInvalid_emptyArrayIsReturned() {
		$repo = new WordpressApiNewsRepository( new StubFileFetcher( '~=[,,_,,]:3' ) );

		$this->assertSame( [], $repo->getLatestNewsItems() );
	}

	public function testWhenJsonIsValid_newsItemsContainCorrectValues() {
		$repo = new WordpressApiNewsRepository( $this->newStubFetcher( 'posts-one-german.json' ) );

		$item = $repo->getLatestNewsItems()[0];

		$this->assertSame( 'Bei den Deutschen funktioniert sogar die Wikipedia!', $item->getTitle() );
		$this->assertSame( 'https://blog.wikimedia.de/2010/11/29/bei-den-deutschen-funktioniert-sogar-die-wikipedia/', $item->getLink() );
		$this->assertStringStartsWith( '<p>Vor einiger Zeit habe ich eine Karte veröffentlicht', $item->getExcerpt() );
		$this->assertStringEndsWith( 'die-wikipedia/">Weiterlesen</a></p>', $item->getExcerpt() );
	}



}
