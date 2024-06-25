<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

final class GroupMember implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $name,
    )
    {
    }

    /** @param array{name: string, identifier: string} $data */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'] ?? null,
            $data['name'] ?? null,
        );
    }


    public static function getPath(): string
    {
        return 'template';
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
