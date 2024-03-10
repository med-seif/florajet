<?php

namespace App\EventSubscriber;

use App\Data\Collector\Article\ArticleCollectionProcessor;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class ArticleCollectorSubscriber implements EventSubscriberInterface
{
    public function __construct(private ArticleCollectionProcessor $processor)
    {
    }

    public function onCollectorDataLoaded(CollectorDataLoadedEvent $event): int|bool
    {
        $articles = $event->getArticles();
        if ($articles) {
            return $this->processor->save($articles);
        }
        return false;

    }

    public static function getSubscribedEvents(): array
    {
        return [
            CollectorDataLoadedEvent::class => 'onCollectorDataLoaded',
        ];
    }
}
