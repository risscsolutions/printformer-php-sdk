<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\Theme;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Theme\Proxy;
use Rissc\Printformer\Client\Theme\ThemeClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): ThemeClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
