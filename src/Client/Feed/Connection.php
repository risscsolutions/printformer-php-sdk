<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 14.04.22
 */

namespace Rissc\Printformer\Client\Feed;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

/**
 * @implements \ArrayAccess<string, string|bool|int>
 */
final class Connection implements \ArrayAccess
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

    /** @param array{host: string, username: string, password: string, path: string, port: int, passive: bool } $data */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['host'] ?? null,
            $data['username'] ?? null,
            $data['password'] ?? null,
            $data['path'] ?? null,
            $data['port'] ?? null,
            $data['passive'] ?? null,
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
