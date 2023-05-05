<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 04.05.22
 */

namespace Rissc\Printformer\Client\Declaration;

use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\Proxy as Base;

/**
 * @internal
 */
class Proxy extends Base implements DeclarationClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private DeclarationClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function list(int $page, int $perPage = 25): Paginator
    {
        return static::wrap(fn(): Paginator => $this->client->list($page, $perPage));
    }

    public function show(string|Declaration $declaration): Declaration
    {
        return static::wrap(fn(): Declaration => $this->client->show($declaration));
    }
}
