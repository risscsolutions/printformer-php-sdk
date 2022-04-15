<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\Derivative;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Derivative\DerivativeClient;
use Rissc\Printformer\Client\Derivative\Proxy;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): DerivativeClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
