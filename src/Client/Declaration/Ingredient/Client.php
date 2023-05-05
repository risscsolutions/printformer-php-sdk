<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.23
 */

namespace Rissc\Printformer\Client\Declaration\Ingredient;

use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Util\BuildsResourcePaths;

/**
 * @internal
 * @extends ResourceClient<Ingredient>
 */
class Client extends ResourceClient implements IngredientClient
{
    /** @uses ListsResources<Ingredient> */
    use ListsResources;
    use BuildsResourcePaths;

    protected static string $resource = Ingredient::class;

    public function show(Ingredient|string $ingredient): Ingredient
    {
        return $this->showResource($ingredient);
    }
}
