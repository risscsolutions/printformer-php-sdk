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
 * @implements \ArrayAccess<string, mixed>
 */
final class Config implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string      $separator,
        public bool        $parseHTML,
        public int         $offset,
        public string      $identifierAttribute,
        public ?string     $url,
        public Polling     $polling,
        public ?Connection $connection,
    )
    {
    }

    /**
     * @param array{
     *  separator: string,
     *  parseHTML: bool,
     *  offset: int,
     *  identifierAttribute: string,
     *  polling: array{
     *      enabled: bool,
     *      interval: int,
     *      dropBeforeImport: bool
     *  },
     *  url?: string,
     *  connection?: array{
     *      host: string,
     *      username: string,
     *      password: string,
     *      path: string,
     *      port: int,
     *      passive: bool
     *     },
     * } $data
     */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['delimiter'] ?? $data['separator'] ?? null,
            $data['parseHTML'] ?? $data['parse_html'] ?? false,
            $data['offset'] ?? null,
            $data['identifierAttribute'] ?? null,
            $data['url'] ?? null,
            Polling::fromArray($data['polling'] ?? []),
            isset($data['connection'])
                ? Connection::fromArray($data['connection'])
                : null
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
