<?php

declare( strict_types = 1 );

namespace App\Domain;

class HtmlString {

	private $html;

	public function __construct( string $html ) {
		$this->html = $html;
	}

	public function getHtml(): string {
		return $this->html;
	}

}
