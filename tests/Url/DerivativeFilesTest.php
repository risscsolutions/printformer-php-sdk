<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 09.11.22
 */

namespace Rissc\Printformer\Tests\Url;

use GuzzleHttp\Psr7\Uri;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Client\Derivative\Derivative;
use Rissc\Printformer\Client\Derivative\DerivativeType;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Url\DerivativeFiles;
use Rissc\Printformer\Url\TokenBuilder;

class DerivativeFilesTest extends TestCase
{
    use ParsesTokens;

    private const TEST_API_TOKEN = 'pqalymxnskwoiela73bdjcnvbfhrutzg';
    private DerivativeFiles $derivativeFiles;

    public function setUp(): void
    {
        parent::setUp();
        $config = [
            'base_uri' => 'https://printformer.test',
            'identifier' => 'test api identifier',
            'api_key' => self::TEST_API_TOKEN
        ];
        $this->derivativeFiles = new DerivativeFiles($config, new TokenBuilder($config));
    }

    public function dataProvider(): \Generator
    {
        yield 'file' => ['file', 'file'];
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

        $url = new Uri((string)$this->derivativeFiles
            ->user(new User('okmlp12', null, null, null, null, null, null, []))
            ->$method(new Derivative('r2nnd1H2', new DerivativeType('saD43n3c', 'my derivative', 'png'), '', '')));

        static::assertEquals('https', $url->getScheme());
        static::assertEquals('printformer.test', $url->getHost());

        $path = sprintf('/api-ext/files/derivative/r2nnd1H2/%s', $pathSegment);
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
