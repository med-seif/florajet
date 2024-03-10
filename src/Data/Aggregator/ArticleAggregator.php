<?php

namespace App\Data\Aggregator;

use App\Data\Collector\Article\AbstractArticleCollector;
use App\Data\Collector\Article\CollectorTypeEnum;
use App\Data\IteratorTrait;
use App\Entity\Article;
use App\EventSubscriber\CollectorDataLoadedEvent;
use App\Repository\ArticleRepository;
use Psr\EventDispatcher\EventDispatcherInterface;


class ArticleAggregator implements \Iterator
{
    use IteratorTrait;

    /**
     * @var Article[]
     */
    private array $data = [];
    private iterable $collectors = [];
    private ArticleRepository $articleRepository;
    private EventDispatcherInterface $dispatcher;
    private CollectorDataLoadedEvent $collectorDataLoadedEvent;

    public function __construct(iterable                 $collectors,
                                ArticleRepository        $articleRepository,
                                EventDispatcherInterface $dispatcher,
                                CollectorDataLoadedEvent $collectorDataLoadedEvent
    )
    {
        # every iterator MUST implement Traversable that's why we use it on testing if type of $collectors is already iterator
        $this->collectors = $collectors instanceof \Traversable ? iterator_to_array($collectors) : $collectors;
        $this->articleRepository = $articleRepository;
        $this->dispatcher = $dispatcher;
        $this->collectorDataLoadedEvent = $collectorDataLoadedEvent;
    }

    public function getArticles(): array
    {
        if (!$this->data) {
            # repository invoking should not be done on constructor but when getting articles to prevent heavy initialisation
            # or declare this service as lazy in order to be instantiated only when called
            $this->data = $this->articleRepository->findAll();;
        }
        return $this->data;
    }

    public function getCollector(CollectorTypeEnum $type): AbstractArticleCollector
    {
        return $this->collectors[$type->value];
    }

    public function appendRss(string $name, string $url) :void
    {
        // TODO : add options resolver
        $articles = $this->getCollector(CollectorTypeEnum::Rss)->collectData([
            'name' => $name,
            'url' => $url
        ]);

        # fire event to load data in local database
        $this->dispatcher->dispatch(
            $this->collectorDataLoadedEvent->setArticles($articles)
        );
    }

    public function appendDatabase(string $host, string $user, string $password, string $dbname): void
    {
        // TODO : add options resolver
        $articles = $this->getCollector(CollectorTypeEnum::Database)->collectData([
                'host' => $host,
                'user' => $user,
                'password' => $password,
                'dbname' => $dbname
            ]
        );
        # fire event to load data in local database
        $this->dispatcher->dispatch(
            $this->collectorDataLoadedEvent
                ->setArticles($articles)
        );
    }

    public function appendFile(string $filename): void
    {
        $articles = $this->getCollector(CollectorTypeEnum::File)->collectData([
                'filename' => $filename
            ]
        );
        $this->dispatcher->dispatch(
            $this->collectorDataLoadedEvent
                ->setArticles($articles)
        );
    }

    public function appendApi(string $endpoint): void
    {
        $articles = $this->getCollector(CollectorTypeEnum::File)->collectData([
                'endpoint' => $endpoint
            ]
        );
        $this->dispatcher->dispatch(
            $this->collectorDataLoadedEvent
                ->setArticles($articles)
        );
    }
}
