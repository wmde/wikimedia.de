<?php

namespace App\DataAccess;

interface NewsRepository {

	/**
	 * @return NewsItem
	 */
	public function getLatestNewsItems(): array;

}