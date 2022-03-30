<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Draft;


class ValidationResult
{
    public function __construct(
        public ?int   $row,
        public int    $page,
        public string $message,
        public string $severity,
    )
    {
    }

    public static function fromArray(array $data): ValidationResult
    {
        return new ValidationResult(
            data_get($data, 'row'),
            data_get($data, 'page'),
            data_get($data, 'message'),
            data_get($data, 'severity'),
        );
    }
}
