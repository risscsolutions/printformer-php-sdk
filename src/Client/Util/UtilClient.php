<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 06.07.24
 */

namespace Rissc\Printformer\Client\Util;

interface UtilClient
{
    public function reAssemble(array $drafts, string $callbackURL): string;
}
