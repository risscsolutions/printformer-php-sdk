<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Url;

use GuzzleHttp\Psr7\Uri;
use Illuminate\Config\Repository;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Url\DraftFiles;
use Rissc\Printformer\Url\TokenBuilder;

class DraftFilesTest extends TestCase
{
    use ParsesTokens;

    private const TEST_API_TOKEN = 'pqalymxnskwoiedjcnvbfhrutzg';
    private DraftFiles $draftFiles;

    public function setUp(): void
    {
        parent::setUp();
        $config = new Repository([
            'base_uri' => 'https://printformer.test',
            'identifier' => 'test api identifier',
            'api_key' => self::TEST_API_TOKEN
        ]);
        $this->draftFiles = new DraftFiles($config, new TokenBuilder($config));
    }

    public function dataProvider(): \Generator
    {
        yield 'preview' => ['preview', 'low-res'];
        yield 'idmlPackage' => ['idmlPackage', 'idml-package'];
        yield 'print' => ['printFile', 'print'];
        yield 'image' => ['image', 'image'];
        yield 'x3d' => ['x3d', 'x3d'];
    }

    /** @dataProvider dataProvider */
    public function testUrlCreation(string $method, string $pathSegment): void
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(self::TEST_API_TOKEN)
        );

        $configuration->setValidationConstraints(
            new SignedWith(
                new Sha256(),
                InMemory::plainText(self::TEST_API_TOKEN)
            ),
            new LooseValidAt(SystemClock::fromUTC())
        );

        $url = new Uri((string)$this->draftFiles
            ->user(new User('okmlp12', null, null, null, null, null, null, []))
            ->$method('1qayxsw223edccvfrr45tgbbnhz6'));

        static::assertEquals('https', $url->getScheme());
        static::assertEquals('printformer.test', $url->getHost());

        $path = sprintf('/api-ext/files/draft/1qayxsw223edccvfrr45tgbbnhz6/%s', $pathSegment);
        static::assertEquals($path, $url->getPath());

        parse_str($url->getQuery(), $query);
        static::assertArrayHasKey('jwt', $query);

        $token = $this->parseToken($configuration, $query['jwt']);
        static::assertFalse($token->headers()->has('jti'));
        $claims = $token->claims();
        static::assertEquals('okmlp12', $claims->get('user'));
        static::assertEquals('test api identifier', $claims->get('client'));
        static::assertEquals($path, $claims->get('urlPath'));
    }
}
