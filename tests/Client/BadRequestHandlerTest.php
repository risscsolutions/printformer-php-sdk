<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Client;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Exceptions\NotFoundException;

class BadRequestHandlerTest extends TestCase
{
    use TestsHTTPCalls;

    protected static BadRequestHandler $badRequestHandler;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        static::$badRequestHandler = new BadRequestHandler();
    }

    public function testNotFound(): void
    {
        static::expectException(NotFoundException::class);
        try {
            $container = [];
            $this->createMockHTTPClient($container, [
                new Response(404, [], json_encode([
                    'message' => 'No query results for model [Printformer\\UserGroup].',
                    'success' => false
                ]))
            ])
                ->get('');
        } catch (BadResponseException $e) {
            static::$badRequestHandler->responseToException($e);
        }
    }

    public function testServerError(): void
    {
        static::expectException(BadResponseException::class);
        try {
            $container = [];
            $this->createMockHTTPClient($container, [
                new Response(500, [], json_encode([
                    'message' => 'We fucked up',
                    'success' => false
                ]))
            ])
                ->get('');
        } catch (BadResponseException $e) {
            static::$badRequestHandler->responseToException($e);
        }
    }
}
