<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use JetBrains\PhpStorm\ArrayShape;

interface ProcessingClient
{
    #[ArrayShape(['draftIds' => 'array', 'stateChangedNotifyUrl' => 'string'])]
    public function create(array $data): Processing;

    public function show(string $identifier): Processing;
}
