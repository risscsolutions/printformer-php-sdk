<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use Rissc\Printformer\Client\Draft\Draft;

interface ProcessingClient
{
    /** @param array<string|Draft> $drafts */
    public function create(array $drafts, ?string $callbackUrl = null): Processing;

    public function show(string|Processing $processing): Processing;
}
