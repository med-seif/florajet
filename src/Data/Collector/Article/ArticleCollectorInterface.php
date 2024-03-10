<?php

namespace App\Data\Collector\Article;

interface ArticleCollectorInterface
{
    public function collectData(array $params = []): array;

    public static function getIndex(): string;
}
