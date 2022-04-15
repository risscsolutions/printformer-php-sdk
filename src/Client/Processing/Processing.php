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
use function data_get;

class Processing implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $processingId,
        public array  $draftStates,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'processingId'),
            array_map(static fn(array $draftState) => DraftState::fromArray($draftState), data_get($data, 'draftStates', []))
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
