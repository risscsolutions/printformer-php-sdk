<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Client;

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
            data_get($meta, 'currentPage'),
            data_get($meta, 'lastPage'),
            data_get($meta, 'perPage'),
            data_get($meta, 'total')
        );
    }
}
