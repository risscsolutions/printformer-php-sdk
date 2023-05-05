<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.22
 */

namespace Rissc\Printformer\Tests\Client\Declaration;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Declaration\DeclarationClient;
use Rissc\Printformer\Client\Declaration\Proxy;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): DeclarationClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
