<?php

declare( strict_types = 1 );

namespace App\Presenter;

use App\Domain\NewsItem;

/**
 * Turns a collection of NewsItem into a View Model for Twig templates
 */
class NewsItemsTwigPresenter {

	private $viewModel;

	public function present( array $newsItems ): void {
		$this->viewModel = array_map(
			function( NewsItem $newsItem ) {
				return [
					'title' => $newsItem->getTitle(),
					'link' => $newsItem->getLink(),
					'image' => $newsItem->getImageUrl(),
					'type_message' => 'news.type.event', // TODO
					'link_message' => 'news.type.event.link', // TODO
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
