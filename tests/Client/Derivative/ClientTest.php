<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Tests\Client\Derivative;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Derivative\Client;
use Rissc\Printformer\Client\Derivative\Derivative;
use Rissc\Printformer\Client\Derivative\DerivativeClient;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): DerivativeClient
    {
        return new Client($http, new User('okmlp12', null, null, null, null, null, null, []));
    }

    public function testList(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'identifier' => 'xyzabc12',
                        'downloadURL' => 'https://url-to-derivative.com',
                        'derivativeType' => [
                            'identifier' => '123xyzab',
                            'label' => 'Test Type',
                            'type' => 'pdf'
                        ],
                        'createdAt' => 'now',
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
        static::assertEquals ('https://printformer.test/api-ext/user/okmlp12/derivative?page=1&per_page=25', (string)$request->getUri());
        static::assertCount(1, $paginator->getData());
        static::assertTrue($paginator->isLast());
        /** @var Derivative $derivative */
        $derivative = head($paginator->getData());
        static::assertEquals('xyzabc12', $derivative->identifier);
        static::assertEquals('https://url-to-derivative.com', $derivative->downloadURL);
        static::assertEquals('now', $derivative->createdAt);
        static::assertEquals('123xyzab', $derivative->derivativeType->identifier);
    }

    public function testShow(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [

                    'identifier' => 'xyzabc12',
                    'downloadURL' => 'https://url-to-derivative.com',
                    'derivativeType' => [
                        'identifier' => '123xyzab',
                        'label' => 'Test Type',
                        'type' => 'pdf'
                    ],
                    'createdAt' => 'now',

                ],
            ])),
        ]);

        $client = static::createAPIClient($http);
        $derivative = $client->show('xyzabc12');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/derivative/xyzabc12', (string)$request->getUri());
        static::assertEquals('xyzabc12', $derivative->identifier);
        static::assertEquals('https://url-to-derivative.com', $derivative->downloadURL);
        static::assertEquals('now', $derivative->createdAt);
        static::assertEquals('123xyzab', $derivative->derivativeType->identifier);
    }
}
