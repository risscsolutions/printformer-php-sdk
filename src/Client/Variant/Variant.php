<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Client\Variant;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

final class Variant implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public int       $id,
        public string    $identifier,
        public string    $name,
        public Thumbnail $thumbnail
    )
    {
    }

    public static function getPath(): string
    {
        return 'variant';
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['id'] ?? null,
            $data['identifier'] ?? null,
            $data['name'] ?? null,
            Thumbnail::fromArray($data)
        );
    }
}
