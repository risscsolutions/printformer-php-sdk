<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 13.04.22
 */

namespace Rissc\Printformer\Tests\Client\User;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\User\Client;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

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

        $client = new Client($http);
        $user = $client->create([
            'email' => 'info@rissc.com'
        ]);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/user', (string)$request->getUri());
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

        $client = new Client($http);
        $user = $client->show('123abcxy');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/user/123abcxy', (string)$request->getUri());
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

        $client = new Client($http);
        $user = $client->update('123abcxy', [
            'email' => 'info@rissc.com'
        ]);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('PUT', $request->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/user/123abcxy', (string)$request->getUri());
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

        $client = new Client($http);
        $user = $client->merge('123abcxy', 'qwertzy12');

        static::assertCount(2, $container);

        /** @var RequestInterface $mergeRequest */
        $mergeRequest = array_shift($container)['request'];
        /** @var RequestInterface $showRequest */
        $showRequest = array_shift($container)['request'];

        static::assertEquals('POST', $mergeRequest->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/user/123abcxy/merge', (string)$mergeRequest->getUri());
        static::assertEquals(json_encode(['source_user_identifier' => 'qwertzy12']), $mergeRequest->getBody()->getContents());

        static::assertEquals('GET', $showRequest->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/user/123abcxy', (string)$showRequest->getUri());

        static::assertEquals('123abcxy', $user->identifier);
        static::assertEquals('info@rissc.com', $user->email);
        static::assertNull($user->firstName);
    }
}
