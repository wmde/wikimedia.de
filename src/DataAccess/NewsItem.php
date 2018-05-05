<?php

declare( strict_types = 1 );

namespace App\DataAccess;

class NewsItem {

	private $title;
	private $link;
	private $excerpt;

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

	public function getTitle(): string {
		return $this->title;
	}

	public function getLink(): string {
		return $this->link;
	}

	public function getExcerpt(): string {
		return $this->excerpt;
	}



}