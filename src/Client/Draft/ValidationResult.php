<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

/** @implements \ArrayAccess<string, string|int|null> */
class ValidationResult implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public ?int   $row,
        public int    $page,
        public string $message,
        public string $severity,
    )
    {
    }

    /** @param array{row: int|null, page: int, message: string, severity: string} $data
     */
    public static function fromArray(array $data): ValidationResult
    {
        return new ValidationResult(
            $data['row'] ?? null,
            $data['page'] ?? null,
            $data['message'] ?? null,
            $data['severity'] ?? null,
        );
    }
}
