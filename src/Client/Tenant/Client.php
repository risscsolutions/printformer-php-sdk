<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Tenant;

use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 */
class Client extends ResourceClient implements TenantClient
{
    protected static string $resource = Tenant::class;

    public function show(): Tenant
    {
        return self::resourceFromResponse($this->get($this->path));
    }
}
