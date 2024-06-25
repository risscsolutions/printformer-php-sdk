<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Tenant;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;

final class Tenant implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $name,
        public string $identifier,
        public string $createdAt,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['name'] ?? null,
            $data['identifier'] ?? null,
            $data['createdAt'] ?? null,
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'client';
    }
}
