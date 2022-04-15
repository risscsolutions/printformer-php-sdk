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
        return $this->id;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'id'),
            data_get($data, 'identifier'),
            data_get($data, 'name'),
            Thumbnail::fromArray($data)
        );
    }
}
