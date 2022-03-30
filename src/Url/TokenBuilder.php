<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Url;

use Illuminate\Config\Repository;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

/**
 * @property string $client
 * @property string $redirect
 * @property string $urlPath
 * @property string $user
 */
class TokenBuilder
{
    private array $claims = [];

    public bool $withJTI = false;
    public \DateTimeImmutable $expiresAt;

    public function __construct(private Repository $config)
    {
    }

    public function __set(string $name, string $value): void
    {
        $this->claims[$name] = $value;
    }

    public function __get(string $name): ?string
    {
        return $this->claims[$name] ?? null;
    }

    public function __toString(): string
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->config->get('api_key'))
        );

        $builder = $configuration->builder()
            ->issuedAt(new \DateTimeImmutable());

        if (isset($this->expiresAt)) {
            $builder->expiresAt($this->expiresAt);
        }

        if ($this->withJTI) {
            $builder->withHeader('jti', Str::random());
        }

        foreach ($this->claims as $claim => $value) {
            $builder->withClaim($claim, $value);
        }

        return $builder
            ->getToken(new Sha256(), InMemory::plainText($this->config->get('api_key')))
            ->toString();
    }
}
