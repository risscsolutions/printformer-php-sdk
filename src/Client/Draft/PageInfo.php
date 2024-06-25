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

/** @implements \ArrayAccess<string, mixed> */
final class PageInfo implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    /** @param array<array{width: float, height: float}> $dimensions */
    public function __construct(
        public int   $pages,
        /** @var  array<array{width: float, height: float}> $dimensions */
        public array $dimensions
    )
    {
    }

    /** @param array{pages:int, dimensions:array<array{width: float, height: float}>} $data */
    public static function fromArray(array $data): PageInfo
    {
        return new PageInfo(
            $data['pages'] ?? null,
            $data['dimensions'] ?? null,
        );
    }
}
