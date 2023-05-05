<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.23
 */

namespace Rissc\Printformer\Client\Declaration\Ingredient;

use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\Proxy as Base;

/**
 * @internal
 */
class Proxy extends Base implements IngredientClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private IngredientClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function list(int $page, int $perPage = 25): Paginator
    {
        return static::wrap(fn(): Paginator => $this->client->list($page, $perPage));
    }

    public function show(string|Ingredient $ingredient): Ingredient
    {
        return static::wrap(fn(): Ingredient => $this->client->show($ingredient));
    }
}
