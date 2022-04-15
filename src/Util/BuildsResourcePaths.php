<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 14.04.22
 */

namespace Rissc\Printformer\Util;

use Rissc\Printformer\Client\Resource;

trait BuildsResourcePaths
{
    protected static function buildResourcePath(Resource $resource, string ...$actions): string
    {
        return implode('/', [$resource::getPath(), $resource->getIdentifier(), ...$actions]);
    }
}
