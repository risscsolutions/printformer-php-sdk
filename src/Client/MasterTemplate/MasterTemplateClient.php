<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Client\ProvidesListing;

/**
 * @extends ProvidesListing<MasterTemplate>
 */
interface MasterTemplateClient extends ProvidesListing
{
    public function show(string|MasterTemplate $template): MasterTemplate;
}
