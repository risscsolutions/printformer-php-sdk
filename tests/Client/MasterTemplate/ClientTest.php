<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Tests\Client\MasterTemplate;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\MasterTemplate\Client;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplate;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplateClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): MasterTemplateClient
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
                        'name' => 'Test Master',
                        'intents' => ['customize'],
                        'pageCount' => 1,
                        'availTemplate' => null,
                        'correctionTemplate' => [
                            'name' => 'Test Avail',
                            'pageCount' => 1
                        ],
                        'groupMembers' => [],
                        'customAttributes' => [],
                        'updatedAt' => 'now',
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
        $masterPaginator = $client->list(1);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/template?page=1&per_page=25', (string)$request->getUri());
        static::assertCount(1, $masterPaginator->getData());
        static::assertTrue($masterPaginator->isLast());
        /** @var MasterTemplate $master */
        $master = head($masterPaginator->getData());
        static::assertEquals('xyzabc12', $master->identifier);
        static::assertEquals('Test Master', $master->name);
        static::assertEquals('now', $master->updatedAt);
    }
}
