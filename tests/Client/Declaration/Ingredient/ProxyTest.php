<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.22
 */

namespace Rissc\Printformer\Tests\Client\Declaration\Ingredient;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Declaration\Ingredient\IngredientClient;
use Rissc\Printformer\Client\Declaration\Ingredient\Proxy;

class ProxyTest extends ClientTest
{
    protected static function createAPIClient(HTTPClient $http): IngredientClient
    {
        return new Proxy(new BadRequestHandler(), parent::createAPIClient($http));
    }
}
