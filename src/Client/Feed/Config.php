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

class Config implements \ArrayAccess, Arrayable
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string      $separator,
        public bool        $parseHTML,
        public int         $offset,
        public string      $identifierAttribute,
        public Polling     $polling,
        public ?Connection $connection,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new Config(
            data_get($data, 'separator'),
            data_get($data, 'parseHTML'),
            data_get($data, 'offset'),
            data_get($data, 'identifierAttribute'),
            Polling::fromArray(data_get($data, 'polling')),
            transform(data_get($data, 'connection'), static fn($connection) => Connection::fromArray($connection)),
        );
    }

    public function toArray()
    {
        return [
            'separator' => $this->separator,
            'parseHTML' => $this->parseHTML,
            'offset' => $this->offset,
            'identifierAttribute' => $this->identifierAttribute,
            'polling' => (array)$this->polling,
            'connection' => $this->connection ? (array)$this->connection : null
        ];
    }
}
