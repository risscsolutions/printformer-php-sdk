<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Derivative;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

/** @implements \ArrayAccess<string, string> */
final class DerivativeType implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $label,
        public string $type,
    )
    {
    }

    /** @param array{identifier: string, label: string, type: string} $data */
    public static function fromArray(array $data): DerivativeType
    {
        return new DerivativeType(
            data_get($data, 'identifier'),
            data_get($data, 'label'),
            data_get($data, 'type'),
        );
    }
}
