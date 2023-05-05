<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.23
 */

namespace Rissc\Printformer\Tests\Client\Declaration\Ingredient;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Declaration\Ingredient\Client;
use Rissc\Printformer\Client\Declaration\Ingredient\Ingredient;
use Rissc\Printformer\Client\Declaration\Ingredient\IngredientClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): IngredientClient
    {
        return new Client($http);
    }

    public function testList(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'identifier' => 'YO5iWZXO',
                        'label' => 'Sulfat',
                        'short' => 'Sulfat',
                        'allergenic' => false,
                        'comment' => 'Sulfat',
                        'quantity' => '100',
                        'divider' => ',',
                        'order' => 0,
                        'data_key' => 'pf-ingredient-0'
                    ]
                ],
                'meta' => [
                    'currentPage' => 1,
                    'lastPage' => 1,
                    'perPage' => 25,
                    'total' => 1,
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $paginator = $client->list(1);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/ingredient?page=1&per_page=25', (string)$request->getUri());
        static::assertCount(1, $paginator->getData());
        static::assertTrue($paginator->isLast());

        /** @var Ingredient $ingredient */
        $ingredient = head($paginator->getData());
        static::assertEquals('YO5iWZXO', $ingredient->identifier);
        static::assertEquals('Sulfat', $ingredient->label);
    }

    public function testShow(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'identifier' => 'YO5iWZXO',
                    'label' => 'Sulfat',
                    'short' => 'Sulfat',
                    'allergenic' => false,
                    'comment' => 'Sulfat',
                    'quantity' => '100',
                    'divider' => ',',
                    'order' => 0,
                    'data_key' => 'pf-ingredient-0'
                ],
            ])),
        ]);

        $client = static::createAPIClient($http);
        $ingredient = $client->show('YO5iWZXO');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/ingredient/YO5iWZXO', (string)$request->getUri());
        static::assertEquals('YO5iWZXO', $ingredient->identifier);
        static::assertEquals('Sulfat', $ingredient->label);
    }
}
