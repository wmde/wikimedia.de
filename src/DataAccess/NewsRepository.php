<?php

declare( strict_types = 1 );

namespace App\DataAccess;

use App\Domain\NewsItem;

interface NewsRepository {

	/**
	 * @return NewsItem[]
	 */
	public function getLatestNewsItems(): array;

}