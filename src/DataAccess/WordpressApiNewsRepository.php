<?php

declare( strict_types = 1 );

namespace App\DataAccess;

use FileFetcher\FileFetcher;
use FileFetcher\FileFetchingException;

class WordpressApiNewsRepository implements NewsRepository {

	public const TAG_ID_DE = 243;
	public const TAG_ID_EN = 464;

	private const API_URL = 'https://blog.wikimedia.de/wp-json/wp/v2/posts';
	private const LOCALE_TO_TAG_ID_MAP = [
		'en' => self::TAG_ID_EN,
		'de' => self::TAG_ID_DE,
	];

	private $fileFetcher;
	private $localeTagId;

	/**
	 * @throws \InvalidArgumentException
	 */
	public function __construct( FileFetcher $fileFetcher, string $locale ) {
		$this->fileFetcher = $fileFetcher;
		$this->setLocaleTagIdFromLocale( $locale );
	}

	private function setLocaleTagIdFromLocale( string $locale ) {
		if ( !array_key_exists( $locale, self::LOCALE_TO_TAG_ID_MAP ) ) {
			throw new \InvalidArgumentException( 'Invalid locale' );
		}

		$this->localeTagId = self::LOCALE_TO_TAG_ID_MAP[$locale];
	}

	/**
	 * @return NewsItem[]
	 */
	public function getLatestNewsItems(): array {
		try {
			return array_map(
				function( array $post ): NewsItem {
					return NewsItem::newInstance()
						->withTitle( $post['title']['rendered'] )
						->withLink( $post['link'] )
						->withExcerpt( trim( $post['excerpt']['rendered'] ) );
				},
				$this->getPostsArray()
			);
		}
		catch ( FileFetchingException $ex ) {
			return [];
		}
	}

	private function getPostsArray(): array {
		$posts = json_decode(
			$this->fileFetcher->fetchFile( $this->getPostsUrl() ),
			true
		);

		if ( is_array( $posts ) ) {
			return $posts;
		}

		return [];
	}

	private function getPostsUrl(): string {
		return self::API_URL
			. '?'
			. http_build_query(
				[
					'tags' => $this->localeTagId
				]
			);
	}

}