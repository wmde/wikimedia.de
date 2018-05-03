<?php

declare( strict_types = 1 );

namespace App\DataAccess;

use FileFetcher\FileFetcher;

class WordpressApiNewsRepository implements NewsRepository {

	private $fileFetcher;

	public function __construct( FileFetcher $fileFetcher ) {
		$this->fileFetcher = $fileFetcher;
	}

	public function getLatestNewsItems(): array {
		// https://blog.wikimedia.de/wp-json/wp/v2/posts
		return [];
	}

}