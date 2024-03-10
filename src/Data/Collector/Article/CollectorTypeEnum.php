<?php

namespace App\Data\Collector\Article;
/**
 * Configuration of collectors type key
 */
enum CollectorTypeEnum: string
{
    case Rss = 'rss';
    case Database = 'database';
    case File = 'file';
    case Api = 'api';
}
