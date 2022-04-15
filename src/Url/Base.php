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
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Util\BuildsQueryStrings;
use Rissc\Printformer\Util\BuildsResourcePaths;
use Rissc\Printformer\Util\UnwrapsResourceIdentifier;

abstract class Base implements \Stringable
{
    use BuildsQueryStrings;
    use BuildsResourcePaths;
    use UnwrapsResourceIdentifier;

    public function __construct(
        protected Repository   $config,
        protected TokenBuilder $tokenBuilder
    )
    {
        $this->tokenBuilder->client = $this->config->get('identifier');
    }

    public function user(string|User $user): self
    {
        $this->tokenBuilder->user = static::unwrapResource($user);
        return $this;
    }

    public function expiresAt(\DateTimeImmutable $expiresAt): self
    {
        $this->tokenBuilder->expiresAt = $expiresAt;
        return $this;
    }

    abstract public function __toString(): string;
}
