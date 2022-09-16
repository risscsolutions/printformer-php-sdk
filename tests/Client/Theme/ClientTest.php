<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 16.09.22
 */

namespace Rissc\Printformer\Tests\Client\Theme;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Theme\Client;
use Rissc\Printformer\Client\Theme\Theme;
use Rissc\Printformer\Client\Theme\ThemeClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): ThemeClient
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
                        'name' => 'Test Theme',
                    ],
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
        $request = head($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/theme?page=1&per_page=25', (string)$request->getUri());
        static::assertCount(1, $masterPaginator->getData());
        static::assertTrue($masterPaginator->isLast());
        /** @var Theme $theme */
        $theme = head($masterPaginator->getData());
        static::assertEquals('xyzabc12', $theme->identifier);
        static::assertEquals('Test Theme', $theme->name);
    }
}
