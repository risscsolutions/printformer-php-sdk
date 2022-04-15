<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Util;

trait BuildsQueryStrings
{
    /** @param array<scalar> $args */
    protected static function buildQuery(array $args): string
    {
        return http_build_query(array_filter($args, static fn(?string $value) => !empty($value)));
    }
}
