<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 04.05.23
 */

namespace Rissc\Printformer\Client\Declaration\Ingredient;

class QuantifiedIngredient extends Ingredient
{
    public function __construct(
        string        $identifier,
        string        $label,
        string        $short,
        string        $allergenic,
        string        $comment,

        public string $quantity,
        public string $divider,
        public string $order,
        public string $dataKey,
    )
    {
        parent::__construct($identifier, $label, $short, $allergenic, $comment);
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'] ?? null,
            $data['label'] ?? null,
            $data['short'] ?? null,
            $data['allergenic'] ?? null,
            $data['comment'] ?? null,
            $data['quantity'] ?? null,
            $data['divider'] ?? null,
            $data['order'] ?? null,
            $data['data_key'] ?? null,
        );
    }
}
