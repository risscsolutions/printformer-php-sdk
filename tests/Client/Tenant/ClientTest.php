<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Tests\Client\Tenant;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Tenant\Client;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    public function testShow(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'data' => [
                    'name' => 'test name',
                    'identifier' => '123abcxy',
                    'createdAt' => 'now',
                ]
            ]))
        ]);

        $client = new Client($http);
        $tenant = $client->show();

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertStringMatchesFormat('https://printformer.test/api-ext/client', (string)$request->getUri());
        static::assertEquals('123abcxy', $tenant->identifier);
        static::assertEquals('test name', $tenant->name);
        static::assertEquals('now', $tenant->createdAt);
    }
}
