<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\User;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\User\Proxy;
use Rissc\Printformer\Client\User\UserClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): UserClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
