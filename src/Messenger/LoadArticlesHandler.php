<?php

namespace App\Messenger;

use App\Data\Aggregator\ArticleAggregator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class LoadArticlesHandler
{
    public function __construct(private ArticleAggregator $articleAggregator)
    {

    }

    public function __invoke(LoadArticlesMessage $message): void
    {
        $content = $message->getContent();
        if ('rss' === $content['type']) {
            $this->articleAggregator->appendRss(
                $content['name'],
                $content['url']
            );
        }
        if ('db' === $content['type']) {
            $this->articleAggregator->appendDatabase(
                host: $content['host'],
                user: $content['user'],
                password: $content['password'],
                dbname: $content['dbname']
            );
        }
    }
}
