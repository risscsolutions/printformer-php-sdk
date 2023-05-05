<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 04.05.23
 */

namespace Rissc\Printformer\Client\Declaration;

use Rissc\Printformer\Client\Declaration\Ingredient\Ingredient;

class Nutrition extends Ingredient
{
    public function __construct(
        string        $identifier,
        string        $label,
        string        $short,
        string        $allergenic,
        string        $comment,
        public string $quantity,
        public string $dailyRequirement,
        public string $order,
        public string $dataKey,
    )
    {
        parent::__construct($identifier, $label, $short, $allergenic, $comment);
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'identifier'),
            data_get($data, 'label'),
            data_get($data, 'short'),
            data_get($data, 'allergenic'),
            data_get($data, 'comment'),
            data_get($data, 'quantity'),
            data_get($data, 'daily_requirement'),
            data_get($data, 'order'),
            data_get($data, 'data_key'),
        );
    }
}
