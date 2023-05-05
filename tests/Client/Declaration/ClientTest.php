<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.23
 */

namespace Rissc\Printformer\Tests\Client\Declaration;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Declaration\Client;
use Rissc\Printformer\Client\Declaration\Declaration;
use Rissc\Printformer\Client\Declaration\DeclarationClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): DeclarationClient
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
                        'identifier' => 'xyzabc12',
                        'label' => 'my awesome decla',
                        'grammage' => '100',
                        'bbd' => '2023-05-05',
                        'comment' => 'my awesome decla',
                        'ingredients' => [
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
                        'nutritionInformation' => [
                            [
                                'identifier' => 'YO5iWZXO',
                                'label' => 'Sulfat',
                                'short' => 'Sulfat',
                                'allergenic' => false,
                                'comment' => 'Sulfat',
                                'quantity' => '100',
                                'daily_requirement' => '100',
                                'order' => 0,
                                'data_key' => 'pf-ingredient-0'
                            ]
                        ],
                        'html' => [
                            'ingredients' => 'Sulfat 100,',
                            'nutritionInformation' => '<table><thead><tr><td>Nährwertangaben<\/td><td>je 100g<\/td><\/tr><\/thead><tbody><tr><td>Sulfat<\/td><td>100(100)<\/td><\/tr><\/tbody><\/table>'
                        ],
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
        static::assertEquals('https://printformer.test/api-ext/declaration?page=1&per_page=25', (string)$request->getUri());
        static::assertCount(1, $paginator->getData());
        static::assertTrue($paginator->isLast());
        /** @var Declaration $declaration */
        $declaration = head($paginator->getData());
        static::assertEquals('xyzabc12', $declaration->identifier);
        static::assertCount(1, $declaration->ingredients);
        static::assertCount(1, $declaration->nutritionInformation);
    }

    public function testShow(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'identifier' => 'xyzabc12',
                    'label' => 'my awesome decla',
                    'grammage' => '100',
                    'bbd' => '2023-05-05',
                    'comment' => 'my awesome decla',
                    'ingredients' => [
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
                    'nutritionInformation' => [
                        [
                            'identifier' => 'YO5iWZXO',
                            'label' => 'Sulfat',
                            'short' => 'Sulfat',
                            'allergenic' => false,
                            'comment' => 'Sulfat',
                            'quantity' => '100',
                            'daily_requirement' => '100',
                            'order' => 0,
                            'data_key' => 'pf-ingredient-0'
                        ]
                    ],
                    'html' => [
                        'ingredients' => 'Sulfat 100,',
                        'nutritionInformation' => '<table><thead><tr><td>Nährwertangaben<\/td><td>je 100g<\/td><\/tr><\/thead><tbody><tr><td>Sulfat<\/td><td>100(100)<\/td><\/tr><\/tbody><\/table>'
                    ],
                ],
            ])),
        ]);

        $client = static::createAPIClient($http);
        $declaration = $client->show('xyzabc12');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/declaration/xyzabc12', (string)$request->getUri());
        static::assertEquals('xyzabc12', $declaration->identifier);
        static::assertCount(1, $declaration->ingredients);
        static::assertCount(1, $declaration->nutritionInformation);
    }
}
