<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Derivative;

use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\Proxy as Base;

/**
 * @internal
 */
class Proxy extends Base implements DerivativeClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private DerivativeClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function list(int $page, int $perPage = 25): Paginator
    {
        return static::wrap(fn(): Paginator => $this->client->list($page, $perPage));
    }

    public function show(string|Derivative $derivative): Derivative
    {
        return static::wrap(fn(): Derivative => $this->client->show($derivative));
    }
}
