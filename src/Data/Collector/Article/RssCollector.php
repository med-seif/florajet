<?php

namespace App\Data\Collector\Article;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;


class RssCollector extends AbstractArticleCollector
{
    public function __construct(
        private readonly \App\Cache\CachingHttpClient $httpClient,
        private readonly DecoderInterface    $decoder)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[\Override]
    public function collectData(array $params = []): array
    {
        $result = $this->httpClient->request('GET', $params['url']);
        $content = $result->getContent();
        $data = $this->decoder->decode($content, 'xml');
        return $this->parseData(
            $data['channel']['item'] ?? [],
            $params['name']
        );
    }

    private function parseData(array $data, string $name): array
    {
        $articles = [];
        foreach ($data as $item) {
            $articles [] = [
                'name' => $item['title'],
                'content' => $item['description'],
                'source_name' => $name
            ];
        }
        return $articles;
    }

    #[\Override]
    public static function getIndex(): string
    {
        return CollectorTypeEnum::Rss->value;
    }
}
