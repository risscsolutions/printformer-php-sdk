<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Client\Review;

use function data_get;

class Review
{
    public function __construct(public string $id)
    {
    }

    public static function fromArray(mixed $data): Review
    {
        return new Review(data_get($data, 'reviewId'));
    }
}
