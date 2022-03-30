<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

interface MasterTemplateClient
{
    public function list(?int $page = null): array;
}
