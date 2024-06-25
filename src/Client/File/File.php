<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\File;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

final class File implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(public string $identifier)
    {
    }

    /** @param array{identifier: string} $data */
    public static function fromArray(array $data): static
    {
        return new static($data['identifier']);
    }

    public static function getPath(): string
    {
        return 'file';
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
