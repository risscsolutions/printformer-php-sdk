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
use Rissc\Printformer\Url\Editor;
use Rissc\Printformer\Url\Review;
use Rissc\Printformer\Url\TokenBuilder;

class ReviewTest extends TestCase
{
    use ParsesTokens;

    private const TEST_API_TOKEN = 'pqalymxnskwoiedjcnvbfhrutzg';
    private Review $review;

    public function setUp(): void
    {
        parent::setUp();
        $config = new Repository([
            'base_uri' => 'https://printformer.test',
            'identifier' => 'test api identifier',
            'api_key' => self::TEST_API_TOKEN
        ]);
        $this->review = new Review($config, new TokenBuilder($config));
    }

    public function testEditor(): void
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

        $url = new Uri(
            (string)$this->review
                ->review('1qayxsw223edccvfrr45tgbbnhz6')
                ->user(new User('okmlp12', null, null, null, null, null, null, []))
        );

        static::assertEquals('https', $url->getScheme());
        static::assertEquals('printformer.test', $url->getHost());
        static::assertEquals('/auth', $url->getPath());

        parse_str($url->getQuery(), $query);
        static::assertArrayHasKey('jwt', $query);

        $token = $this->parseToken($configuration, $query['jwt']);
        static::assertTrue($token->headers()->has('jti'));
        $claims = $token->claims();
        static::assertEquals('okmlp12', $claims->get('user'));
        static::assertEquals('test api identifier', $claims->get('client'));
        static::assertEquals('https://printformer.test/review/1qayxsw223edccvfrr45tgbbnhz6', $claims->get('redirect'));
    }
}
