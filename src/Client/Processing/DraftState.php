<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Client\Processing;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

/** @implements \ArrayAccess<string, string|null> */
final class DraftState implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string  $draftId,
        public string  $state,
        public ?string $message,
    )
    {
    }

    /** @param array{draftId: string, state: string, message: ?string} $data */
    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'draftId'),
            data_get($data, 'state'),
            data_get($data, 'message'),
        );
    }
}
