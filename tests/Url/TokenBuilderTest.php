<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 13.04.22
 */

namespace Rissc\Printformer\Tests\Url;

use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Url\TokenBuilder;

class TokenBuilderTest extends TestCase
{
    use ParsesTokens;

    private const TEST_API_TOKEN = 'pqalymxnskwoiela73bdjcnvbfhrutzg';
    private TokenBuilder $tokenBuilder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tokenBuilder = new TokenBuilder([
            'api_key' => self::TEST_API_TOKEN
        ]);
    }

    public function testEmptyToken(): void
    {
        $this->tokenBuilder->expiresAt = (new \DateTimeImmutable())->modify('+1 hour');
        $this->tokenBuilder->withJTI = true;
        $tokenString = (string)$this->tokenBuilder;

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

        $token = $this->parseToken($configuration, $tokenString);

        $claims = $token->claims()->all();
        static::assertCount(2, $claims);
        static::assertArrayHasKey('iat', $claims);
        static::assertArrayHasKey('exp', $claims);

        static::assertArrayHasKey('jti', $token->headers()->all());
    }

    public function testTokenWithClaims(): void
    {
        $this->tokenBuilder->first = 'abc';
        $this->tokenBuilder->second = true;
        $this->tokenBuilder->third = 123;
        $tokenString = (string)$this->tokenBuilder;

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

        $token = $this->parseToken($configuration, $tokenString);

        foreach ([
                     'first' => 'abc',
                     'second' => true,
                     'third' => 123,
                 ] as $k => $v) {
            static::assertEquals($v, $token->claims()->get($k));
        }
    }
}
