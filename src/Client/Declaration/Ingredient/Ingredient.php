<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 04.05.23
 */

namespace Rissc\Printformer\Client\Declaration\Ingredient;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

class Ingredient implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $label,
        public string $short,
        public string $allergenic,
        public string $comment,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'identifier'),
            data_get($data, 'label'),
            data_get($data, 'short'),
            data_get($data, 'allergenic'),
            data_get($data, 'comment'),
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'ingredient';
    }
}
