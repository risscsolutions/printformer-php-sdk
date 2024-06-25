<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Tests\Client\VariableData;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\VariableData\Client;
use Rissc\Printformer\Client\VariableData\VariableDataClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): VariableDataClient
    {
        return new Client($http, 'fwenuzgfhueidnqe7tquqnfww');
    }

    public function testList(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    ['a' => 1,], ['a' => 2,], ['a' => 3,], ['a' => 4,], ['a' => 5,], ['a' => 6,],
                    ['a' => 7,], ['a' => 8,], ['a' => 9,], ['a' => 10,], ['a' => 11,], ['a' => 12,],
                    ['a' => 13,], ['a' => 14,], ['a' => 15,], ['a' => 16,], ['a' => 17,], ['a' => 18,],
                    ['a' => 19,], ['a' => 20,], ['a' => 21,], ['a' => 22,], ['a' => 23,], ['a' => 24,],
                    ['a' => 25,],
                ],
                '_meta' => [
                    'amountOfRows' => 25,
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $vdPaginator = $client->list(1);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/fwenuzgfhueidnqe7tquqnfww/variable-data?limit=25', (string)$request->getUri());
        static::assertCount(25, $vdPaginator->getData());
        static::assertTrue($vdPaginator->isLast());
    }

    public function testUpdate(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(204, [], json_encode([])),
        ]);

        $client = static::createAPIClient($http);
        static::assertTrue($client->update([
            2 => ['a' => 26]
        ]));

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('PUT', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/fwenuzgfhueidnqe7tquqnfww/variable-data', (string)$request->getUri());
        static::assertEquals(json_encode(['data' => [2 => ['a' => 26]]]), $request->getBody()->getContents());
    }
}
