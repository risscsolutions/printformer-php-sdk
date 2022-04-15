<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\Variant;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Variant\Proxy;
use Rissc\Printformer\Client\Variant\VariantClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): VariantClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
