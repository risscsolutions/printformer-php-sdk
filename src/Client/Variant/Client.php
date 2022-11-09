<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Client\Variant;

use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<Variant>
 */
class Client extends ResourceClient implements VariantClient
{
    /** @use ListsResources<Variant> */
    use ListsResources;

    protected static string $resource = Variant::class;
}
