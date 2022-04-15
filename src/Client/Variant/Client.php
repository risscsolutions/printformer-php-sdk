<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Client\Variant;

use GuzzleHttp\Utils;
use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<Variant>
 * @uses ListsResources<Variant>
 */
class Client extends ResourceClient implements VariantClient
{
    use ListsResources;

    protected static string $resource = Variant::class;
}
