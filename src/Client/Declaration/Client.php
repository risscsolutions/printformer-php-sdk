<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 04.05.23
 */

namespace Rissc\Printformer\Client\Declaration;

use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Util\BuildsResourcePaths;

/**
 * @internal
 * @extends ResourceClient<Declaration>
 */
class Client extends ResourceClient implements DeclarationClient
{
    /** @use ListsResources<Declaration> */
    use ListsResources;
    use BuildsResourcePaths;

    protected static string $resource = Declaration::class;

    public function show(string|Declaration $declaration): Declaration
    {
        return $this->showResource($declaration);
    }
}
