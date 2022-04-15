<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Derivative;

use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ProvidesListing;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @extends ResourceClient<Derivative>
 */
interface DerivativeClient extends ProvidesListing
{
    /**
     * @inheritDoc
     * @return Paginator<Derivative>
     */
    public function list(int $page): Paginator;

    public function show(string|Derivative $derivative): Derivative;
}
