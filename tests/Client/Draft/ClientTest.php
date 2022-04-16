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
                    'preflightStatus' => null,
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
}
