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

interface DerivativeClient extends ProvidesListing
{
    /**
     * @inheritDoc
     * @return Paginator<int, Derivative>
     */
    public function list(int $page): Paginator;

    public function show(string|Derivative $derivative): Derivative;
}
