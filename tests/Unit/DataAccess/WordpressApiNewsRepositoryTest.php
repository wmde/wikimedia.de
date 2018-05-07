<?php

declare( strict_types = 1 );

namespace App\Tests\Unit\DataAccess;

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
	 * @var SpyingFileFetcher
	 */
	private $fileFetcher;

	/**
	 * @var string
	 */
	private $repoLocale;

	public function setUp() {
		$this->fileFetcher = new SpyingFileFetcher( $this->newStubFetcher( 'posts-several.json' ) );
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

		$this->assertContainsOnlyInstancesOf( \App\Domain\NewsItem::class, $items );
		$this->assertNotEmpty( $items );
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
		$this->assertStringEndsWith( '…', $item->getExcerpt() );

		$this->assertSame( 'https://blog.wikimedia.de/wp-content/uploads/image3-300x200-1.png', $item->getImageUrl() );

		$this->assertSame( \App\Domain\NewsItem::CATEGORY_COMMUNITY, $item->getCategory() );
	}

	public function testWhenLocaleIsEn_englishTagIsUsed() {
		$this->newRepository()->getLatestNewsItems();

		$this->assertContains(
			'tags=' . WordpressApiNewsRepository::TAG_ID_EN,
			$this->fileFetcher->getFirstFetchedUrl()
		);
	}

	public function testWhenLocaleIsDe_germanTagIsUsed() {
		$this->repoLocale = 'de';

		$this->newRepository()->getLatestNewsItems();

		$this->assertContains(
			'tags=' . WordpressApiNewsRepository::TAG_ID_DE,
			$this->fileFetcher->getFirstFetchedUrl()
		);
	}

	public function testWhenLocaleIsUnknown_constructorThrowsException() {
		$this->repoLocale = 'maw';

		$this->expectException( \InvalidArgumentException::class );
		$this->newRepository();
	}

	public function testWhenImageIsMissing_postDoesNotGetIncluded() {
		$this->fileFetcher = new SpyingFileFetcher( $this->newStubFetcher( 'posts-only-3-with-image.json' ) );
		$this->assertCount( 3, $this->newRepository()->getLatestNewsItems() );
	}

}
