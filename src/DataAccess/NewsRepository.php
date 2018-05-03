<?php

declare( strict_types = 1 );

namespace App\DataAccess;

interface NewsRepository {

	/**
	 * @return NewsItem
	 */
	public function getLatestNewsItems(): array;

}