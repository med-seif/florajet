<?php

namespace App\Data\Collector\Article;

use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class ApiCollector implements ArticleCollectorInterface
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    #[\Override]
    public function collectData(array $params = []): array
    {
        return [];
    }

    #[\Override]
    public static function getIndex(): string
    {
        return CollectorTypeEnum::Api->value;
    }
}
