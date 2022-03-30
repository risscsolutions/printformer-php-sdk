<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

interface ProcessingClient
{
    public function create(array $drafts, ?string $callbackUrl = null): Processing;

    public function show(string $identifier): Processing;
}
