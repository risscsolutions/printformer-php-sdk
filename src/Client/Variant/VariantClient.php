<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Client\Variant;

use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ProvidesListing;

interface VariantClient extends ProvidesListing
{
    /**
     * @inheritDoc
     * @return Paginator<int, Variant>
     */
    public function list(int $page): Paginator;
}
