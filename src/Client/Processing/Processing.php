<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;

final class Processing implements Resource
{
    use AccessPropertiesAsArray;

    /** @param array<DraftState> $draftStates */
    public function __construct(
        public string $processingId,
        public array  $draftStates,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['processingId'] ?? null,
            array_map(static fn(array $draftState) => DraftState::fromArray($draftState), $data['draftStates'] ?? [])
        );
    }

    public function getIdentifier(): string
    {
        return $this->processingId;
    }

    public static function getPath(): string
    {
        return 'pdf-processing';
    }
}
