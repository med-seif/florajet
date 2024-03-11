<?php

namespace App\Controller;

use App\Data\Aggregator\ArticleAggregator;
use App\Messenger\LoadArticlesMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(
        ArticleAggregator   $articleAggregator,
        MessageBusInterface $bus
    ): JsonResponse
    {
        $bus->dispatch(new LoadArticlesMessage([
            'type' => 'rss',
            'name' => 'Le Monde',
            'url' => 'http://www.lemonde.fr/rss/une.xml'
        ]));
        $bus->dispatch(new LoadArticlesMessage([
            'type' => 'db',
            'host' => 'localhost',
            'user' => 'app',
            'password' => 'florajet',
            'dbname' => 'florajet'
        ]));
        //$articleAggregator->appendRss('Le Monde', 'http://www.lemonde.fr/rss/une.xml');
        //$articleAggregator->appendDatabase(host: 'localhost', user: 'app', password: 'florajet', dbname: 'florajet');

        $articles = $articleAggregator->getArticles();
        $data = [];
        # if this logic will be duplicated elsewhere, we should then use a custom serializer ane implement normalize method
        foreach ($articles as $article) {
            $data [] = [
                'id' => $article->getId(),
                'name' => $article->getName(),
                'content' => $article->getContent(),
                'source' => [
                    'id' => $article->getSourceId()->getId(),
                    'name' => $article->getSourceId()->getName()
                ]
            ];
        }
        return $this->json($data);
    }
}
