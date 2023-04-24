<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 14.04.22
 */

namespace Rissc\Printformer\Client\Feed;

use Illuminate\Contracts\Support\Arrayable;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

/**
 * @implements \ArrayAccess<string, bool|int>
 * @implements Arrayable<string, bool|int>
 */
final class Polling implements \ArrayAccess, Arrayable
{
    use AccessPropertiesAsArray;

    public function __construct(
        public bool   $enabled,
        public string $interval,
        public bool   $dropBeforeImport,
    )
    {
    }

    /** @param array{enabled: bool, interval: int, dropBeforeImport: bool} $data */
    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'enabled'),
            data_get($data, 'interval'),
            data_get($data, 'dropBeforeImport'),
        );
    }

    public function toArray()
    {
        return [
            'enabled' => $this->enabled,
            'interval' => $this->interval,
            'dropBeforeImport' => $this->dropBeforeImport,
        ];
    }
}
