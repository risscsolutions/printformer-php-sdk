<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.09.22
 */

namespace Rissc\Printformer\Client\Theme;

use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\ResourceClient;

class Client extends ResourceClient implements ThemeClient
{
    /** @use ListsResources<Theme> */
    use ListsResources;

    protected static string $resource = Theme::class;
}
