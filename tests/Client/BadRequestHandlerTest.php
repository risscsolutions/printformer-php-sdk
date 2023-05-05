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
use Rissc\Printformer\Exceptions\FeatureNotEnabledException;
use Rissc\Printformer\Exceptions\MaintenanceException;
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

    public function testMaintenance(): void
    {
        static::expectException(MaintenanceException::class);
        try {
            $container = [];
            $this->createMockHTTPClient($container, [
                new Response(502, [], json_encode([
                    'message' => 'We deploy atm',
                    'success' => false
                ]))
            ])
                ->get('');
        } catch (BadResponseException $e) {
            static::$badRequestHandler->responseToException($e);
        }
    }

    public function testFeatureNotEnabled(): void
    {
        static::expectException(FeatureNotEnabledException::class);
        try {
            $container = [];
            $this->createMockHTTPClient($container, [
                new Response(403, [], json_encode([
                    'message' => 'This endpoint is not available in your current subscription. Please contact our support.',
                    'success' => false
                ]))
            ])
                ->get('');
        } catch (BadResponseException $e) {
            static::$badRequestHandler->responseToException($e);
        }
    }

    public function testOtherError(): void
    {
        static::expectException(BadResponseException::class);
        try {
            $container = [];
            $this->createMockHTTPClient($container, [
                new Response(418, [], json_encode([
                    'message' => 'I am a Tea Pot',
                    'success' => false
                ]))
            ])
                ->get('');
        } catch (BadResponseException $e) {
            static::$badRequestHandler->responseToException($e);
        }
    }
}
