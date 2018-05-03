<?php

namespace App\DataAccess;

class NewsItem {

	private $title;
	private $link;
	private $excerpt;

	private function __construct() {
	}

	public function newInstance(): self {
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


}