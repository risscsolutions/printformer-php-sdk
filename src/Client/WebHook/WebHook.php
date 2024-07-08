<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 08.07.24
 */

namespace Rissc\Printformer\Client\WebHook;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

class WebHook implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $event,
        public string $url,
        public int    $status,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'],
            $data['event'],
            $data['url'],
            $data['status'],
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'webhook';
    }

    public function isOperational(): bool
    {
        return $this->status === 0;
    }

    public function isDegraded(): bool
    {
        return $this->status === 1;
    }

    public function isBroken(): bool
    {
        return $this->status === 2;
    }
}
