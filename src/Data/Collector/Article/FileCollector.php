<?php

namespace App\Data\Collector\Article;

class FileCollector extends AbstractArticleCollector
{
    #[\Override]
    public function collectData(array $params = []): array
    {
        return [];
    }

    #[\Override]
    public static function getIndex(): string
    {
        return CollectorTypeEnum::File->value;
    }
}
