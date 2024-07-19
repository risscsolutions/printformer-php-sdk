<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 06.07.24
 */

namespace Rissc\Printformer\Client\Util;

use Rissc\Printformer\Client\File\File;

interface UtilClient
{
    public function reAssemble(array $drafts, string $callbackURL): void;

    public function optimize(string|File $file, string $callbackURL, ?int $dpi = null): void;
}
