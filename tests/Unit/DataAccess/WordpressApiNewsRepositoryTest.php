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

}
