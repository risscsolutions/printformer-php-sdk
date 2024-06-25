<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Client;

use Rissc\Printformer\Util\Util;

final class PaginationMeta
{
    public function __construct(
        public int $currentPage,
        public int $lastPage,
        public int $perPage,
        public int $total,
    )
    {
    }

    public static function fromArray(mixed $meta): PaginationMeta
    {
        return new PaginationMeta(
            Util::get($meta, 'currentPage'),
            Util::get($meta, 'lastPage'),
            Util::get($meta, 'perPage'),
            Util::get($meta, 'total')
        );
    }
}
