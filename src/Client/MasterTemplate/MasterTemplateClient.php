<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ProvidesListing;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @extends ResourceClient<MasterTemplate>
 */
interface MasterTemplateClient extends ProvidesListing
{
    /**
     * @inheritDoc
     * @return Paginator<MasterTemplate>
     */
    public function list(int $page): Paginator;
}
