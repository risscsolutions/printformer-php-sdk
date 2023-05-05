<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.23
 */

namespace Rissc\Printformer\Client\Declaration\Ingredient;

use Rissc\Printformer\Client\ProvidesListing;

/**
 * @extends ProvidesListing<Ingredient>
 */
interface IngredientClient extends ProvidesListing
{
    public function show(string|Ingredient $ingredient): Ingredient;
}
