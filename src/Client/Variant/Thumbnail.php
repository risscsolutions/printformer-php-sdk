<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Client\Variant;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

/** @implements \ArrayAccess<string, string> */
abstract class Thumbnail implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(public string $value)
    {
    }

    /** @param array{thumbnail_type: string, thumbnail_value:string} $data */
    public static function fromArray(array $data): Thumbnail
    {
        if (($data['thumbnail_type'] ?? null) === 'color') return new Color($data['thumbnail_value'] ?? null);
        if (($data['thumbnail_type'] ?? null) === 'image') return new Image($data['thumbnail_value'] ?? null);
        throw new \InvalidArgumentException();
    }
}
