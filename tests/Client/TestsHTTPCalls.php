<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Tests\Client;

use GuzzleHttp\Client as HTTPClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

trait TestsHTTPCalls
{
    protected function createMockHTTPClient(array &$container, array $responses, array $headers = []): HTTPClient
    {
        $history = Middleware::history($container);
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push($history);

        return new HTTPClient([
            'base_uri' => 'https://printformer.test/api-ext/',
            'headers' => array_merge([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer test-token'
            ], $headers),
            'handler' => $stack
        ]);
    }
}
