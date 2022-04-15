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
 * @implements \ArrayAccess<string, string|bool|int>
 * @implements Arrayable<string, string|bool|int>
 */
final class Connection implements \ArrayAccess, Arrayable
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $host,
        public string $username,
        public string $password,
        public string $path,
        public int    $port,
        public bool   $passive,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'host'),
            data_get($data, 'username'),
            data_get($data, 'password'),
            data_get($data, 'path'),
            data_get($data, 'port'),
            data_get($data, 'passive'),
        );
    }

    public function toArray()
    {
        return [
            'host' => $this->host,
            'username' => $this->username,
            'password' => $this->password,
            'path' => $this->path,
            'port' => $this->port,
            'passive' => $this->passive,
        ];
    }

}
