<?php

namespace App\Factory;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class HttpCacheFactory
{
    public function __construct(
        #[Autowire(param: 'kernel.cache_dir')]
        private readonly string $cacheDir)
    {
    }

    public function create(): \App\Cache\CachingHttpClient
    {
        $store = new Store($this->cacheDir);
        $client = HttpClient::create();
        return new \App\Cache\CachingHttpClient($client, $store);
    }
}
