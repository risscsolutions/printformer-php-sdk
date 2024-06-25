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
            $data['identifier'] ?? null,
            $data['label'] ?? null,
            $data['short'] ?? null,
            $data['allergenic'] ?? null,
            $data['comment'] ?? null,
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
