<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\Draft;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Draft\DraftClient;
use Rissc\Printformer\Client\Draft\Proxy;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): DraftClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
