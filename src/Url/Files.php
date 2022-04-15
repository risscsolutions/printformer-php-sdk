<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 14.04.22
 */

namespace Rissc\Printformer\Url;

use Rissc\Printformer\Client\Resource;

abstract class Files extends Base
{
    /** @var class-string<Resource> */
    protected static string $resource;
    protected static string $path = '/api-ext/files';

    protected function buildPath(string|Resource $resource, string $action): string
    {
        return sprintf('%s/%s',
            self::$path,
            is_string($resource)
                ? implode('/', [static::$resource::getPath(), $resource, $action])
                : self::buildResourcePath($resource, $action)
        );
    }
}
