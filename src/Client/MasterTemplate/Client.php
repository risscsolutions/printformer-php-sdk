<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<MasterTemplate>
 */
class Client extends ResourceClient implements MasterTemplateClient
{
    /** @use ListsResources<MasterTemplate> */
    use ListsResources;

    protected static string $resource = MasterTemplate::class;
}
