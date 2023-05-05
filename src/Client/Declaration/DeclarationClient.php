<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 04.05.23
 */

namespace Rissc\Printformer\Client\Declaration;

use Rissc\Printformer\Client\ProvidesListing;

/**
 * @extends ProvidesListing<Declaration>
 */
interface DeclarationClient extends ProvidesListing
{
    public function show(string|Declaration $declaration): Declaration;
}
