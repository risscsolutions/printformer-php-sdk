<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\VariableData;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\VariableData\Proxy;
use Rissc\Printformer\Client\VariableData\VariableDataClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): VariableDataClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
