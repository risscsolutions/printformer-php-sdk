<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

/** @implements \ArrayAccess<string, string|int> */
final class AvailTemplate implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $name,
        public int    $pageCount,
    )
    {
    }

    /** @param array{name: string, pageCount: int} $data */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['name'] ?? null,
            $data['pageCount'] ?? null,
        );
    }
}
