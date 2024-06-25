<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Tests\Client\Variant;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface as HTTPClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Rissc\Printformer\Client\Variant\Client;
use Rissc\Printformer\Client\Variant\Color;
use Rissc\Printformer\Client\Variant\Image;
use Rissc\Printformer\Client\Variant\Variant;
use Rissc\Printformer\Client\Variant\VariantClient;
use Rissc\Printformer\Tests\Client\TestsHTTPCalls;

class ClientTest extends TestCase
{
    use TestsHTTPCalls;

    protected static function createAPIClient(HTTPClient $http): VariantClient
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
                        'id' => 1,
                        'identifier' => 'xyzabc12',
                        'name' => 'Blue',
                        'thumbnail_type' => 'color',
                        'thumbnail_value' => '#0000FF'
                    ],
                    [
                        'id' => 2,
                        'identifier' => 'dfgabcyz',
                        'name' => 'Red',
                        'thumbnail_type' => 'color',
                        'thumbnail_value' => '#FF0000'
                    ],
                    [
                        'id' => 3,
                        'identifier' => 'qawsy123',
                        'name' => 'Gold',
                        'thumbnail_type' => 'image',
                        'thumbnail_value' => 'https://some-image-url.com'
                    ]
                ],
                'meta' => [
                    'currentPage' => 1,
                    'lastPage' => 1,
                    'perPage' => 25,
                    'total' => 3,
                ]
            ])),
        ]);

        $client = static::createAPIClient($http);
        $masterPaginator = $client->list(1);

        static::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = reset($container)['request'];

        static::assertEquals('GET', $request->getMethod());
        static::assertEquals ('https://printformer.test/api-ext/variant?page=1&per_page=25', (string)$request->getUri());
        static::assertTrue($masterPaginator->isLast());

        $variants = $masterPaginator->getData();

        static::assertCount(3, $variants);

        /** @var Variant $variant */
        $variant = array_shift($variants);
        static::assertEquals('xyzabc12', $variant->identifier);
        static::assertEquals('Blue', $variant->name);
        static::assertInstanceOf(Color::class, $variant->thumbnail);
        static::assertEquals('#0000FF', $variant->thumbnail->value);

        /** @var Variant $variant */
        $variant = array_shift($variants);
        static::assertEquals('dfgabcyz', $variant->identifier);
        static::assertEquals('Red', $variant->name);
        static::assertInstanceOf(Color::class, $variant->thumbnail);
        static::assertEquals('#FF0000', $variant->thumbnail->value);

        /** @var Variant $variant */
        $variant = array_shift($variants);
        static::assertEquals('qawsy123', $variant->identifier);
        static::assertEquals('Gold', $variant->name);
        static::assertInstanceOf(Image::class, $variant->thumbnail);
        static::assertEquals('https://some-image-url.com', $variant->thumbnail->value);
    }
}
