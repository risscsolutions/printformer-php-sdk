<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 04.05.23
 */

namespace Rissc\Printformer\Client\Declaration;

use Rissc\Printformer\Client\Declaration\Ingredient\QuantifiedIngredient;
use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Util\Util;

class Declaration implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $label,
        public string $grammage,
        public string $bbd,
        public string $comment,

        public array  $ingredients,
        public array  $nutritionInformation,
        public string $ingredientsHTML,
        public string $nutritionInformationHTML,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'] ?? null,
            $data['label'] ?? null,
            $data['grammage'] ?? null,
            $data['bbd'] ?? null,
            $data['comment'] ?? null,

            array_map(static fn(array $entry) => QuantifiedIngredient::fromArray($entry), $data['ingredients'] ?? []),
            array_map(static fn(array $entry) => Nutrition::fromArray($entry), $data['nutritionInformation'] ?? []),

            Util::get($data, 'html.ingredients'),
            Util::get($data, 'html.nutritionInformation'),
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'declaration';
    }
}
