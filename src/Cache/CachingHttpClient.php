<?php

namespace App\Cache;

use Symfony\Component\HttpClient\CachingHttpClient as CachingHttpClientComponent;

/**
 * A service class for the symfony CachingHttpClient component
 * parent class is final , only add methods not override !
 */
class CachingHttpClient extends CachingHttpClientComponent
{

}
