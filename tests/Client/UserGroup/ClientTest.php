<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Tests\Client\UserGroup;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\UserGroup\Client;
use Rissc\Printformer\Exceptions\NotFoundException;
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
                ]
            ]))
        ]);

        $client = new Client($http);
        $userGroup = $client->create();

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/user-group', (string)$request->getUri());
        static::assertEquals('123abcxy', $userGroup->identifier);
    }

    public function testShowSuccess(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'identifier' => '123abcxy',
                ]
            ]))
        ]);

        $client = new Client($http);
        $userGroup = $client->show('123abcxy');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/user-group/123abcxy', (string)$request->getUri());
        static::assertEquals('123abcxy', $userGroup->identifier);
    }

    public function testShowNotFound(): void
    {
        static::expectException(ClientException::class);
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(404, [], json_encode([
                'message' => 'No query results for model [Printformer\\UserGroup].',
                'success' => false
            ]))
        ]);

        $client = new Client($http);
        $client->show('123abcxy');
    }
}
