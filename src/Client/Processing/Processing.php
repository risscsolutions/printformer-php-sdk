<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use function data_get;

class Processing
{
    public function __construct(
        public string $processingId,
        public array  $draftIds,
    )
    {
    }

    public static function fromArray(array $data): Processing
    {
        return new Processing(
            data_get($data, 'processingId'),
            data_get($data, 'draftIds')
        );
    }
}
