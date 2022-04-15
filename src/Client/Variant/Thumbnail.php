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

abstract class Thumbnail implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(public string $value)
    {
    }

    public static function fromArray(array $data): Thumbnail
    {
        if (data_get($data, 'thumbnail_type') === 'color') return new Color(data_get($data, 'thumbnail_value'));
        if (data_get($data, 'thumbnail_type') === 'image') return new Image(data_get($data, 'thumbnail_value'));
        throw new \InvalidArgumentException();
    }
}
