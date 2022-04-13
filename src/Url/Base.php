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
use Rissc\Printformer\Util\BuildsQueryStrings;

abstract class Base implements \Stringable
{
    use BuildsQueryStrings;

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
}
