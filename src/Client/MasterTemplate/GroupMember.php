<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

class GroupMember implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $name,
    )
    {
    }

    public static function fromArray(array $data): GroupMember
    {
        return new GroupMember(
            data_get($data, 'identifier'),
            data_get($data, 'name'),
        );
    }
}
