<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Tests\Client\UserGroup;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\UserGroup\Client;
use Rissc\Printformer\Client\UserGroup\UserGroupClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): UserGroupClient
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
                ]
            ]))
        ]);

        $client = static::createAPIClient($http);
        $userGroup = $client->create();

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user-group', (string)$request->getUri());
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

        $client = static::createAPIClient($http);
        $userGroup = $client->show('123abcxy');

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/user-group/123abcxy', (string)$request->getUri());
        static::assertEquals('123abcxy', $userGroup->identifier);
    }
}
