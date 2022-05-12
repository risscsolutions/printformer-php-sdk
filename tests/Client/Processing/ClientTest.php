<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client\Processing;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Processing\Client;
use Rissc\Printformer\Client\Processing\ProcessingClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): ProcessingClient
    {
        return new Client($http);
    }

    public function testCreate(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(201, [], json_encode([
                'processingId' => 'wq3t43t4gfewdcg43r23ef',
            ])),
            new Response(200, [], json_encode([
                'processingId' => 'wq3t43t4gfewdcg43r23ef',
                'draftStates' => [[
                    'draftId' => 'wijeruh3r2efwfeqfew',
                    'state' => 'pending',
                    'message' => null
                ], [
                    'draftId' => 'adiugawdudiawfhffeff23',
                    'state' => 'pending',
                    'message' => null
                ]]
            ]))
        ]);

        $client = static::createAPIClient($http);
        $processing = $client->create(['wijeruh3r2efwfeqfew', 'adiugawdudiawfhffeff23']);

        static::assertCount(2, $container);

        static::assertEquals('wq3t43t4gfewdcg43r23ef', $processing->processingId);
        static::assertEquals('wijeruh3r2efwfeqfew', head($processing->draftStates)->draftId);

        /** @var RequestInterface $request */
        $request = array_shift($container)['request'];

        static::assertEquals('POST', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/pdf-processing', (string)$request->getUri());
        static::assertEquals(json_encode([
            'draftIds' => ['wijeruh3r2efwfeqfew', 'adiugawdudiawfhffeff23']
        ]), $request->getBody()->getContents());

        /** @var RequestInterface $request */
        $request = array_shift($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/pdf-processing/wq3t43t4gfewdcg43r23ef', (string)$request->getUri());
    }

    public function testShow(): void
    {
        $container = [];
        $http = $this->createMockHTTPClient($container, [
            new Response(200, [], json_encode([
                'processingId' => 'wq3t43t4gfewdcg43r23ef',
                'draftStates' => [[
                    'draftId' => 'wijeruh3r2efwfeqfew',
                    'state' => 'pending',
                    'message' => null
                ], [
                    'draftId' => 'adiugawdudiawfhffeff23',
                    'state' => 'pending',
                    'message' => null
                ]]
            ]))
        ]);

        $client = static::createAPIClient($http);
        $processing = $client->show('wq3t43t4gfewdcg43r23ef');

        static::assertCount(1, $container);

        static::assertEquals('wijeruh3r2efwfeqfew', head($processing->draftStates)->draftId);

        /** @var RequestInterface $request */
        $request = array_shift($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals('https://printformer.test/api-ext/pdf-processing/wq3t43t4gfewdcg43r23ef', (string)$request->getUri());
    }
}
