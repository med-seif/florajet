<?php

namespace App\Controller\Api;

use App\Repository\ArticleRepository;
use App\Repository\SourceRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class ApiArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly SourceRepository $sourceRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    #[Route('/api/get_article_by_source_name', name: 'app_api_article')]
    public function getArticlesBySourceName(
        #[MapQueryParameter] string $source
    ): JsonResponse
    {
        $data = $this->articleRepository->getArticlesBySourceName($source);
        return $this->json($data);
    }

    #[Route('/api/get_articles', name: 'app_api_get_article')]
    public function getArticles(
    ): JsonResponse
    {
        $data = $this->articleRepository->findAll();
        return $this->json($data);
    }

    #[Route('/api/get_sources', name: 'app_api_get_sources')]
    public function getSources(
    ): JsonResponse
    {
        $data = $this->sourceRepository->findAll();
        return $this->json($data);
    }
}
