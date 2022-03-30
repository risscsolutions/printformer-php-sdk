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

abstract class Base
{
    public function __construct(
        protected Repository   $config,
        protected TokenBuilder $tokenBuilder
    )
    {
        $this->tokenBuilder->client = $this->config->get('identifier');
    }

    public function user(string $user): self
    {
        $this->tokenBuilder->user = $user;
        return $this;
    }

    public function expiresAt(\DateTimeImmutable $expiresAt): self
    {
        $this->tokenBuilder->expiresAt = $expiresAt;
        return $this;
    }

    abstract public function __toString(): string;

    protected static function buildQuery(array $args): string
    {
        return http_build_query(array_filter($args, static fn(?string $value) => !empty($value)));
    }
}
