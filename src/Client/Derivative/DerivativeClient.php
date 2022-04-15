<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Derivative;

use Rissc\Printformer\Client\ProvidesListing;

/**
 * @extends ProvidesListing<Derivative>
 */
interface DerivativeClient extends ProvidesListing
{
    public function show(string|Derivative $derivative): Derivative;
}
