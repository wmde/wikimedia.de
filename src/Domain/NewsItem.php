<?php

declare( strict_types = 1 );

namespace App\Domain;

class NewsItem {

	public const CATEGORY_COMMUNITY = 'community';
	public const CATEGORY_TECHNOLOGY = 'tech';
	public const CATEGORY_ORGANIZATION = 'org';
	public const CATEGORY_WIKIMEDIA = 'wikimedia';
	public const CATEGORY_NONE = 'none';

	private $title;
	private $link;
	private $excerpt;
	private $imageUrl;
	private $category;

	private function __construct() {
	}

	public static function newInstance(): self {
		return new self();
	}

	public function withTitle( string $title ): self {
		$this->title = $title;
		return $this;
	}

	public function withLink( string $link ): self {
		$this->link = $link;
		return $this;
	}

	public function withExcerpt( string $excerpt ): self {
		$this->excerpt = $excerpt;
		return $this;
	}

	public function withImageUrl( string $imageUrl ): self {
		$this->imageUrl = $imageUrl;
		return $this;
	}

	public function withCategory( string $category ): self {
		$this->category = $category;
		return $this;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function getLink(): string {
		return $this->link;
	}

	public function getExcerpt(): string {
		return $this->excerpt;
	}

	public function getImageUrl(): string {
		return $this->imageUrl;
	}

	public function getCategory(): string {
		return $this->category;
	}

}