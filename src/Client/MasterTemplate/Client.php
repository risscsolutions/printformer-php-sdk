<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use GuzzleHttp\Utils;
use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Client\Variant\Variant;

/**
 * @internal
 * @extends ResourceClient<MasterTemplate>
 * @extends ListsResources<Variant>
 */
class Client extends ResourceClient implements MasterTemplateClient
{
    use ListsResources;

    protected static string $resource = MasterTemplate::class;
}
