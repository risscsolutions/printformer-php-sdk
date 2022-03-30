<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Tests\Client\Tenant;

use GuzzleHttp\Client as HTTPClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Tenant\Client;

class ClientTest extends TestCase
{
    public function testShow(): void
    {
        $container = [];
        $history = Middleware::history($container);
        $stack = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'name' => 'test name',
                    'identifier' => 'test identifier',
                    'createdAt' => 'now',
                ]
            ])),
        ]));
        $stack->push($history);

        $http = new HTTPClient([
            'base_uri' => 'https://printformer.test/api-ext/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer test-token'
            ],
            'handler' => $stack
        ]);

        $client = new Client($http);
        $tenant = $client->show();

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/client', (string)$request->getUri());
        static::assertEquals('test identifier', $tenant->identifier);
        static::assertEquals('test name', $tenant->name);
        static::assertEquals('now', $tenant->createdAt);
    }
}
