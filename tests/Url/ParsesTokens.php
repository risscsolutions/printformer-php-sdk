<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Url;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;

trait ParsesTokens
{
    private function parseToken(Configuration $configuration, string $tokenString): UnencryptedToken
    {
        /** @var UnencryptedToken $token */
        $token = $configuration->parser()->parse($tokenString);
        static::assertInstanceOf(UnencryptedToken::class, $token);
        static::assertTrue($configuration->validator()->validate($token, ...$configuration->validationConstraints()));
        return $token;
    }
}
