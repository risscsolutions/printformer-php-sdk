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
use Rissc\Printformer\Client\Resource;

/** @implements Resource<string, mixed> */
final class Derivative implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string         $identifier,
        public DerivativeType $derivativeType,
        public string         $downloadURL,
        public string         $createdAt
    )
    {
    }

    /** @param array{identifier: string, derivativeType: array{identifier: string, label: string, type: string}, downloadURL: string, createdAt: string} $data */
    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'identifier'),
            DerivativeType::fromArray(data_get($data, 'derivativeType')),
            data_get($data, 'downloadURL'),
            data_get($data, 'createdAt'),
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'derivative';
    }
}
