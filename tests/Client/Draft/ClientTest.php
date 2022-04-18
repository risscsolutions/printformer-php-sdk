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
use Rissc\Printformer\Client\Draft\DraftClient;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): DraftClient
    {
        return new Client($http);
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
        static::assertStringMatchesFormat('https://printformer.test/api-ext/draft', (string)$request->getUri());
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
        static::assertStringMatchesFormat('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre', (string)$request->getUri());
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
        static::assertStringMatchesFormat('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre', (string)$request->getUri());
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
        static::assertStringMatchesFormat('https://printformer.test/api-ext/draft/2138r43r90fojnduewfbnwmcfgre/replicate', (string)$request->getUri());
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
        static::assertStringMatchesFormat('https://printformer.test/api-ext/draft/claim', (string)$request->getUri());
        static::assertEquals([
            'user_identifier' => 'hugz6745',
            'drafts' => ['fwenuzgfhueidnqe7tquqnfww', '2138r43r90fojnduewfbnwmcfgre'],
            'dryRun' => false], Utils::jsonDecode($request->getBody()->getContents(), true));
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
        static::assertStringMatchesFormat('https://printformer.test/api-ext/draft/fwenuzgfhueidnqe7tquqnfww', (string)$request->getUri());
    }
}
