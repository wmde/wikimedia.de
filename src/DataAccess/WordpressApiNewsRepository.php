<?php

declare( strict_types = 1 );

namespace App\DataAccess;

use App\Domain\HtmlString;
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

	private const API_URL = 'https://blog.wikimedia.de/wp-json/wp/v2/posts?_embed&per_page=7&';

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
			$postsArray = $this->getPostsArray();

		}
		catch ( FileFetchingException $ex ) {
			return [];
		}

		return array_map(
			function ( array $post ): NewsItem {
				return $this->newNewsItem( $post );
			},
			array_filter(
				$postsArray,
				function( array $post ) {
					return $this->hasImage( $post );
				}
			)
		);
	}

	private function newNewsItem( array $post ): NewsItem {
		return NewsItem::newInstance()
			->withTitle( $post['title']['rendered'] )
			->withLink( $post['link'] )
			->withExcerpt( $this->getExcerpt( $post ) )
			->withCategory( $this->getCategory( $post ) )
			->withImageUrl( $this->getImageUrl( $post ) )
			->withImageAttribution( $this->getImageAttribution( $post ) );
	}

	private function hasImage( array $post ): bool {
		return array_key_exists( 'wp:featuredmedia', $post['_embedded'] );
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

	private function getExcerpt( array $post ): HtmlString {
		$parts = explode( '… <a href=', trim( $post['excerpt']['rendered'] ) );
		return new HtmlString( $parts[0] . '…' );
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
		return $post['_embedded']['wp:featuredmedia'][0]['source_url'];
	}

	private function getImageAttribution( array $post ): HtmlString {
		$imageData = $post['_embedded']['wp:featuredmedia'][0];

		if ( array_key_exists( 'caption', $imageData ) ) {
			return new HtmlString( trim( $imageData['caption']['rendered'] ) );
		}

		return new HtmlString( '' );
	}

}