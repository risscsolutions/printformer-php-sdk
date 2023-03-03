<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 16.04.22
 */

namespace Rissc\Printformer\Tests\Client\Draft;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Utils;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Draft\Client;
use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\Draft\DraftClient;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplate;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): DraftClient
    {
        return new Client($http);
    }

    public function testIndex(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'userIdentifier' => 'pkojbvdd',
                        'userGroupIdentifier' => null,
                        'templateIdentifier' => '123abcxy',
                        'activeGroupTemplateIdentifier' => null,
                        'draftHash' => '2138r43r90fojnduewfbnwmcfgre',
                        'personalizations' => ['amount' => 0],
                        'preflightStatus' => -1,
                        'variant' => [
                            'id' => null,
                            'version' => null
                        ],
                        'apiDefaultValues' => [],
                        'customAttributes' => [],
                        'state' => 'init',
                        'setupStatus' => 'pending',
                        'validationResults' => []
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
        $draftPaginator = $client->list(1);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft?page=1&per_page=25', (string)$request->getUri());
        static::assertCount(1, $draftPaginator->getData());
        static::assertTrue($draftPaginator->isLast());
        /** @var Draft $draft */
        $draft = head($draftPaginator->getData());
        static::assertEquals('123abcxy', $draft->templateIdentifier);
    }

    public function testCreate(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(201, [], json_encode([
                'data' => [
                    'userIdentifier' => 'pkojbvdd',
                    'userGroupIdentifier' => null,
                    'templateIdentifier' => '123abcxy',
                    'activeGroupTemplateIdentifier' => null,
                    'draftHash' => '2138r43r90fojnduewfbnwmcfgre',
                    'personalizations' => ['amount' => 0],
                    'preflightStatus' => -1,
                    'variant' => [
                        'id' => null,
                        'version' => null
                    ],
                    'apiDefaultValues' => [],
                    'customAttributes' => [],
                    'state' => 'init',
                    'setupStatus' => 'pending',
                    'validationResults' => []
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $draft = $client->create([
            'intent' => 'customize',
            'templateIdentifier' => '123abcxy',
            'userIdentifier' => new User('okmlp12', null, null, null, null, null, null, []),
        ]);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft', (string)$request->getUri());
        static::assertEquals('123abcxy', $draft->templateIdentifier);
    }

    public function testShow(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'userIdentifier' => 'pkojbvdd',
                    'userGroupIdentifier' => null,
                    'templateIdentifier' => '123abcxy',
                    'activeGroupTemplateIdentifier' => null,
                    'draftHash' => '2138r43r90fojnduewfbnwmcfgre',
                    'personalizations' => ['amount' => 0],
                    'preflightStatus' => -1,
                    'variant' => [
                        'id' => null,
                        'version' => null
                    ],
                    'apiDefaultValues' => [],
                    'customAttributes' => [],
                    'state' => 'init',
                    'setupStatus' => 'pending',
                    'validationResults' => []
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $draft = $client->show('2138r43r90fojnduewfbnwmcfgre');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre', (string)$request->getUri());
        static::assertEquals('123abcxy', $draft->templateIdentifier);
        static::assertEquals('pending', $draft->setupStatus);
    }

    public function testUpdate(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'userIdentifier' => 'pkojbvdd',
                    'userGroupIdentifier' => null,
                    'templateIdentifier' => '123abcxy',
                    'activeGroupTemplateIdentifier' => null,
                    'draftHash' => '2138r43r90fojnduewfbnwmcfgre',
                    'personalizations' => ['amount' => 0],
                    'preflightStatus' => -1,
                    'variant' => [
                        'id' => null,
                        'version' => null
                    ],
                    'apiDefaultValues' => [],
                    'customAttributes' => ['pf-ca-test' => 123],
                    'state' => 'init',
                    'setupStatus' => 'pending',
                    'validationResults' => []
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $draft = $client->update('2138r43r90fojnduewfbnwmcfgre', ['customAttributes' => ['pf-ca-test' => 123],]);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('PUT', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre', (string)$request->getUri());
        static::assertEquals(['customAttributes' => ['pf-ca-test' => 123]], Utils::jsonDecode($request->getBody()->getContents(), true));
        static::assertEquals('123abcxy', $draft->templateIdentifier);
        static::assertEquals(['pf-ca-test' => 123], $draft->customAttributes);
    }

    public function testReplicate(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'userIdentifier' => 'pkojbvdd',
                    'userGroupIdentifier' => null,
                    'templateIdentifier' => '123abcxy',
                    'activeGroupTemplateIdentifier' => null,
                    'draftHash' => 'fwenuzgfhueidnqe7tquqnfww',
                    'personalizations' => ['amount' => 0],
                    'preflightStatus' => -1,
                    'variant' => [
                        'id' => null,
                        'version' => null
                    ],
                    'apiDefaultValues' => [],
                    'customAttributes' => ['pf-ca-test' => 123],
                    'state' => 'init',
                    'setupStatus' => 'pending',
                    'validationResults' => []
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $draft = $client->replicate('2138r43r90fojnduewfbnwmcfgre', ['customAttributes' => ['pf-ca-test' => 123],]);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre/replicate', (string)$request->getUri());
        static::assertEquals(['customAttributes' => ['pf-ca-test' => 123]], Utils::jsonDecode($request->getBody()->getContents(), true));
        static::assertEquals('fwenuzgfhueidnqe7tquqnfww', $draft->draftHash);
        static::assertEquals('123abcxy', $draft->templateIdentifier);
        static::assertEquals(['pf-ca-test' => 123], $draft->customAttributes);
    }

    public function testClaim(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'fwenuzgfhueidnqe7tquqnfww' => true,
                '2138r43r90fojnduewfbnwmcfgre' => true
            ])),
        ]);

        $client = static::createAPIClient($http);
        $client->claim('hugz6745', ['fwenuzgfhueidnqe7tquqnfww', '2138r43r90fojnduewfbnwmcfgre']);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/claim', (string)$request->getUri());
        static::assertEquals([
            'user_identifier' => 'hugz6745',
            'drafts' => ['fwenuzgfhueidnqe7tquqnfww', '2138r43r90fojnduewfbnwmcfgre'],
            'dryRun' => false], Utils::jsonDecode($request->getBody()->getContents(), true));
    }

    public function testPageInfo(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'pages' => 3,
                    'dimensions' => [
                        ['width' => 100, 'height' => 100],
                        ['width' => 100, 'height' => 100],
                        ['width' => 100, 'height' => 100]
                    ]
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $pageInfo = $client->pageInfo('2138r43r90fojnduewfbnwmcfgre', 'print');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre/print/page-info', (string)$request->getUri());
        static::assertEquals(3, $pageInfo->pages);
    }

    public function testRequestIDMLPackage(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(204, [], json_encode([])),
        ]);

        $client = static::createAPIClient($http);
        static::assertTrue($client->requestIdmlPackage('2138r43r90fojnduewfbnwmcfgre', 'https://my-callback.url'));

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre/request-idml-package', (string)$request->getUri());
        static::assertEquals(json_encode(['callbackURL' => 'https://my-callback.url']), $request->getBody()->getContents());
    }

    public function testDestroy(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(204, [], json_encode([]))
        ]);

        $client = static::createAPIClient($http);
        static::assertTrue($client->destroy('fwenuzgfhueidnqe7tquqnfww'));

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('DELETE', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/draft/fwenuzgfhueidnqe7tquqnfww', (string)$request->getUri());
    }
}
