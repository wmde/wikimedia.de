<?php

declare( strict_types = 1 );

namespace App\DataAccess;

use App\Domain\NewsItem;
use FileFetcher\FileFetcher;
use FileFetcher\FileFetchingException;

class WordpressApiNewsRepository implements NewsRepository {

	public const TAG_ID_DE = 243;
	public const TAG_ID_EN = 464;

	private const LOCALE_TO_TAG_ID_MAP = [
		'en' => self::TAG_ID_EN,
		'de' => self::TAG_ID_DE,
	];

	public const CATEGORY_ID_COMMUNITY = 179;
	public const CATEGORY_ID_TECHNOLOGY = 1298;
	public const CATEGORY_ID_GESELLSCHAFT = 1299;
	public const CATEGORY_ID_WIKIMEDIA = 1297;

	private const CATEGORY_ID_TO_NAME_MAP = [
		self::CATEGORY_ID_COMMUNITY => NewsItem::CATEGORY_COMMUNITY,
		self::CATEGORY_ID_TECHNOLOGY => NewsItem::CATEGORY_TECHNOLOGY,
		self::CATEGORY_ID_GESELLSCHAFT => NewsItem::CATEGORY_ORGANIZATION,
		self::CATEGORY_ID_WIKIMEDIA => NewsItem::CATEGORY_WIKIMEDIA,
	];

	private const API_URL = 'https://blog.wikimedia.de/wp-json/wp/v2/posts?_embed&per_page=5&';

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
				function ( array $post ): NewsItem {
					return NewsItem::newInstance()
						->withTitle( $post['title']['rendered'] )
						->withLink( $post['link'] )
						->withExcerpt( $this->getExcerpt( $post ) )
						->withCategory( $this->getCategory( $post ) )
						->withImageUrl( $this->getImageUrl( $post ) );
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
			. http_build_query(
				[
					'tags' => $this->localeTagId
				]
			);
	}

	private function getExcerpt( array $post ): string {
		$parts = explode( '… <a href=', trim( $post['excerpt']['rendered'] ) );
		return $parts[0] . '…';
	}

	private function getCategory( array $post ): string {
		foreach ( $post['categories'] as $categoryId ) {
			if ( array_key_exists( $categoryId, self::CATEGORY_ID_TO_NAME_MAP ) ) {
				return self::CATEGORY_ID_TO_NAME_MAP[$categoryId];
			}
		}

		return NewsItem::CATEGORY_NONE;
	}

	private function getImageUrl( array $post ): string {
		if ( array_key_exists( 'wp:featuredmedia', $post['_embedded'] ) ) {
			return $post['_embedded']['wp:featuredmedia'][0]['source_url'];
		}

		return 'TODO'; // TODO
	}

}