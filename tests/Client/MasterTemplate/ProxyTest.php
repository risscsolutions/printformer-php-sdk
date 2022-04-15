<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\MasterTemplate;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\MasterTemplate\Proxy;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplateClient;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): MasterTemplateClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
