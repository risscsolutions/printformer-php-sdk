<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Tests\Client\UserGroup;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\UserGroup\Client;
use Rissc\Printformer\Client\UserGroup\Proxy;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ProxyTest extends TestCase
{
    use TestsHTTPCalls;

    public function testShowNotFound(): void
    {
        static::expectException(NotFoundException::class);
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(404, [], json_encode([
                'message' => 'No query results for model [Printformer\\UserGroup].',
                'success' => false
            ]))
        ]);

        $client = new Proxy(new BadRequestHandler(), new Client($http));
        $client->show('123abcxy');
    }
}
