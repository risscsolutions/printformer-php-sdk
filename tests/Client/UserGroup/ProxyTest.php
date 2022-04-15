<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Tests\Client\UserGroup;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\UserGroup\Proxy;
use Rissc\Printformer\Client\UserGroup\UserGroupClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): UserGroupClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
