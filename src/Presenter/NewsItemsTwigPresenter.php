<?php

declare( strict_types = 1 );

namespace App\Presenter;

use App\Domain\NewsItem;

/**
 * Turns a collection of NewsItem into a View Model for Twig templates
 */
class NewsItemsTwigPresenter {

	private $viewModel;

	private const CATEGORY_MESSAGE_MAP = [
		NewsItem::CATEGORY_COMMUNITY => 'news.category.community',
		NewsItem::CATEGORY_WIKIMEDIA => 'news.category.wikimedia',
		NewsItem::CATEGORY_TECHNOLOGY => 'news.category.technology',
		NewsItem::CATEGORY_ORGANIZATION => 'news.category.politik',
		NewsItem::CATEGORY_NONE => 'news.category.none',
	];

	public function present( array $newsItems ): void {
		$this->viewModel = array_map(
			function( NewsItem $newsItem ) {
				return [
					'title' => $newsItem->getTitle(),
					'link' => $newsItem->getLink(),
					'image' => $newsItem->getImageUrl(),
					'type_message' => self::CATEGORY_MESSAGE_MAP[$newsItem->getCategory()],
					'link_message' => 'news.view.more.link',
					'text' => $newsItem->getExcerpt()
				];
			},
			$newsItems
		);
	}

	public function getViewModel(): array {
		return $this->viewModel;
	}

}
