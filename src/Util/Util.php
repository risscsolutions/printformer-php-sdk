<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 25.06.24
 */

namespace Rissc\Printformer\Util;

class Util
{
    public static function get(array|object $target, string $key)
    {
        $key = explode('.', $key);

        foreach ($key as $segment) {
            if (is_array($target) && array_key_exists($segment, $target)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return null;
            }
        }

        return $target;
    }
}
