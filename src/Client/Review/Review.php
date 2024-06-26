<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Client\Review;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;

final class Review implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(public string $id)
    {
    }

    public static function fromArray(mixed $data): static
    {
        return new static($data['reviewId'] ?? null);
    }

    public function getIdentifier(): string
    {
        return $this->id;
    }

    public static function getPath(): string
    {
        return 'review';
    }
}
