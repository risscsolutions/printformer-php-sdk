<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client;

trait UnwrapsResourceIdentifier
{
    protected function getIdentifier(string|Resource $resource): string
    {
        return is_string($resource) ? $resource : $resource->getIdentifier();
    }
}
