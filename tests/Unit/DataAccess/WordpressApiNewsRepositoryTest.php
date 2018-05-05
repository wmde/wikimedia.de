<?php

declare( strict_types = 1 );

namespace App\Tests\Unit\DataAccess;

use App\DataAccess\NewsItem;
use App\DataAccess\NewsRepository;
use App\DataAccess\WordpressApiNewsRepository;
use App\Tests\TestData;
use FileFetcher\FileFetcher;
use FileFetcher\SpyingFileFetcher;
use FileFetcher\StubFileFetcher;
use FileFetcher\ThrowingFileFetcher;
use PHPUnit\Framework\TestCase;

/**
 * @covers WordpressApiNewsRepository
 */
class WordpressApiNewsRepositoryTest extends TestCase {

	/**
	 * @var FileFetcher
	 */
	private $fileFetcher;

	/**
	 * @var string
	 */
	private $repoLocale;

	public function setUp() {
		$this->fileFetcher = new SpyingFileFetcher( $this->newStubFetcher( 'posts-several-english.json' ) );
		$this->repoLocale = 'en';
	}

	private function newStubFetcher( string $fileName ): FileFetcher {
		return new StubFileFetcher( TestData::getFileContents( 'blog/' . $fileName ) );
	}

	private function newRepository(): NewsRepository {
		return new WordpressApiNewsRepository(
			$this->fileFetcher,
			$this->repoLocale
		);
	}

	public function testWhenFileFetcherThrowsException_emptyArrayIsReturned() {
		$this->fileFetcher = new ThrowingFileFetcher();

		$this->assertSame( [], $this->newRepository()->getLatestNewsItems() );
	}

	public function testWhenJsonIsValid_newsItemsAreReturned() {
		$items = $this->newRepository()->getLatestNewsItems();

		$this->assertContainsOnlyInstancesOf( NewsItem::class, $items );
		$this->assertCount( 10, $items );
	}

	public function testWhenJsonIsInvalid_emptyArrayIsReturned() {
		$this->fileFetcher = new StubFileFetcher( '~=[,,_,,]:3' );

		$this->assertSame( [], $this->newRepository()->getLatestNewsItems() );
	}

	public function testWhenJsonIsValid_newsItemsContainCorrectValues() {
		$item = $this->newRepository()->getLatestNewsItems()[0];

		$this->assertSame( 'WikidataCon 2017', $item->getTitle() );
		$this->assertSame( 'https://blog.wikimedia.de/2017/11/13/wikidatacon-2017/', $item->getLink() );
		$this->assertStringStartsWith( '<p>WikidataCon, the first conference dedicated', $item->getExcerpt() );
		$this->assertStringEndsWith( 'wikidatacon-2017/">Weiterlesen</a></p>', $item->getExcerpt() );
	}



}
