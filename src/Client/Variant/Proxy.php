<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Variant;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements VariantClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private VariantClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function list(?int $page = null): Paginator
    {
        return $this->wrap(fn(): Paginator => $this->client->list($page));
    }
}
