<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Util;

use Rissc\Printformer\Client\Resource;

trait UnwrapsResourceIdentifier
{
    protected static function unwrapOptionalResource(string|Resource|null $resource): ?string
    {
        return $resource ? static::unwrapResource($resource) : null;
    }

    protected static function unwrapResource(string|Resource $resource): string
    {
        return is_string($resource) ? $resource : $resource->getIdentifier();
    }

    /**
     * @param array<string|Resource> $resources
     * @return array<string>
     */
    protected static function unwrapArray(array $resources): array
    {
        return array_map(fn(string|Resource $resource): string => static::unwrapResource($resource), $resources);
    }
}
