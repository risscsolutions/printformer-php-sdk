<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\UserGroup;

use function data_get;

class UserGroup
{
    public function __construct(public string $identifier)
    {
    }

    public static function fromArray(array $data): self
    {
        return new UserGroup(data_get($data, 'identifier'));
    }
}
