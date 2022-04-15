<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\UserGroup;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;
use function data_get;

/** @implements \Resource<string, string> */
final class UserGroup implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(public string $identifier)
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(data_get($data, 'identifier'));
    }

    public static function getPath(): string
    {
        return 'user-group';
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
