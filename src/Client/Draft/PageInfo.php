<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

class PageInfo implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public int   $pages,
        public array $dimensions
    )
    {
    }

    public static function fromArray(array $data): PageInfo
    {
        return new PageInfo(
            data_get($data, 'pages'),
            data_get($data, 'dimensions'),
        );
    }
}
