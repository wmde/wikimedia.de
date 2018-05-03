<?php

namespace App\Tests\Unit\DataAccess;

use App\DataAccess\WordpressApiNewsRepository;
use FileFetcher\ThrowingFileFetcher;
use PHPUnit\Framework\TestCase;

class WordpressApiNewsRepositoryTest extends TestCase {

	public function testWhenFileFetcherThrowsException_emptyArrayIsReturned() {
		$repo = new WordpressApiNewsRepository( new ThrowingFileFetcher() );

		$this->assertSame( [], $repo->getLatestNewsItems() );
	}

}
