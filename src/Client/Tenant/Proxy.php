<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Tenant;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements TenantClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private TenantClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function show(): Tenant
    {
        return $this->wrap(fn(): Tenant => $this->client->show());
    }
}
