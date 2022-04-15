<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\Tenant;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Tenant\Proxy;
use Rissc\Printformer\Client\Tenant\TenantClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): TenantClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
