<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 13.04.22
 */

namespace Rissc\Printformer\Tests\Client\User;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\User\Client;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Client\User\UserClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): UserClient
    {
        return new Client($http);
    }

    public function testCreate(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(201, [], json_encode([
                'data' => [
                    'identifier' => '123abcxy',
                    'profile' => [
                        'email' => 'info@rissc.com'
                    ]
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $user = $client->create([
            'email' => 'info@rissc.com'
        ]);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user', (string)$request->getUri());
        static::assertEquals('123abcxy', $user->identifier);
        static::assertEquals('info@rissc.com', $user->email);
        static::assertNull($user->firstName);
    }

    public function testShowSuccess(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'identifier' => '123abcxy',
                    'profile' => [
                        'email' => 'info@rissc.com'
                    ]
                ]
            ]))
        ]);

        $client = static::createAPIClient($http);
        $user = $client->show('123abcxy');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user/123abcxy', (string)$request->getUri());
        static::assertEquals('123abcxy', $user->identifier);
        static::assertEquals('info@rissc.com', $user->email);
        static::assertNull($user->firstName);
    }

    public function testUpdate(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'identifier' => '123abcxy',
                    'profile' => [
                        'email' => 'info@rissc.com'
                    ]
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $user = $client->update('123abcxy', [
            'email' => 'info@rissc.com'
        ]);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('PUT', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user/123abcxy', (string)$request->getUri());
        static::assertEquals('123abcxy', $user->identifier);
        static::assertEquals('info@rissc.com', $user->email);
        static::assertNull($user->firstName);
    }

    public function testMerge(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'success' => true
            ])),
            new Response(200, [], json_encode([
                'data' => [
                    'identifier' => '123abcxy',
                    'profile' => [
                        'email' => 'info@rissc.com'
                    ]
                ]
            ]))
        ]);

        $client = static::createAPIClient($http);
        $user = $client->merge('123abcxy', 'qwertzy12');

        static::assertCount(2, $container);

        /** @var RequestInterface $mergeRequest */
        $mergeRequest = array_shift($container)['request'];
        /** @var RequestInterface $showRequest */
        $showRequest = array_shift($container)['request'];

        static::assertEquals('POST', $mergeRequest->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user/123abcxy/merge', (string)$mergeRequest->getUri());
        static::assertEquals(json_encode(['source_user_identifier' => 'qwertzy12']), $mergeRequest->getBody()->getContents());

        static::assertEquals('GET', $showRequest->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user/123abcxy', (string)$showRequest->getUri());

        static::assertEquals('123abcxy', $user->identifier);
        static::assertEquals('info@rissc.com', $user->email);
        static::assertNull($user->firstName);
    }

    public function testDestroy(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(204, [], json_encode([])),
        ]);

        $client = static::createAPIClient($http);

        static::assertTrue($client->destroy(new User('123abcxy', null, null, null, null, null, null, [])));

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('DELETE', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user/123abcxy', (string)$request->getUri());
    }
}
