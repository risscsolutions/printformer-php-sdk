<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.09.22
 */

namespace Rissc\Printformer\Client\Theme;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

final class Theme implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $name
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'] ?? null,
            $data['name'] ?? null,
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'theme';
    }
}
