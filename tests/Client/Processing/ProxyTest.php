<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\Processing;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Processing\Proxy;
use Rissc\Printformer\Client\Processing\ProcessingClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): ProcessingClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
