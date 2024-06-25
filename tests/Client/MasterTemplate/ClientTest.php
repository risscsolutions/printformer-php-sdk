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
use Rissc\Printformer\Client\MasterTemplate\GroupMember;
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
                        'type' => 'customizable',
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
        $request = reset($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/template?page=1&per_page=25', (string)$request->getUri());
        $data = $masterPaginator->getData();
        static::assertCount(1, $data);
        static::assertTrue($masterPaginator->isLast());
        /** @var MasterTemplate $master */
        $master = reset($data);
        static::assertEquals('xyzabc12', $master->identifier);
        static::assertEquals('Test Master', $master->name);
        static::assertEquals('now', $master->updatedAt);
    }

    public function testShow(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'identifier' => 'xyzabc12',
                    'name' => 'Test Master',
                    'type' => 'customizable',
                    'intents' => ['customize'],
                    'pageCount' => 1,
                    'availTemplate' => null,
                    'correctionTemplate' => [
                        'name' => 'Test Avail',
                        'pageCount' => 1
                    ],
                    'groupMembers' => [
                        [
                            'identifier' => 'j2nd672w',
                            'name' => 'Test Member',
                        ]
                    ],
                    'customAttributes' => [],
                    'updatedAt' => 'now',
                ],
            ])),
        ]);

        $client = static::createAPIClient($http);
        $master = $client->show('xyzabc12');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/template/xyzabc12', (string)$request->getUri());

        static::assertEquals('xyzabc12', $master->identifier);
        static::assertEquals('Test Master', $master->name);
        static::assertEquals('now', $master->updatedAt);
        static::assertCount(1, $master->groupMembers);
        static::assertInstanceOf(GroupMember::class, $master->groupMembers[0]);
    }
}
