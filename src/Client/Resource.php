<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client;

interface Resource extends \ArrayAccess
{
    public static function getPath(): string;

    public function getIdentifier(): string;

    /** @param array<mixed> $data */
    public static function fromArray(array $data): static;
}
