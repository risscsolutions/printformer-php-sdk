<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\File;

class File
{
    public function __construct(public string $identifier)
    {
    }

    public static function fromArray(array $data): File
    {
        return new File(data_get($data, 'identifier'));
    }
}
