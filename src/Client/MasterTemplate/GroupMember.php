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

class GroupMember implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $name,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'identifier'),
            data_get($data, 'name'),
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
