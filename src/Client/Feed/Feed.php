<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Feed;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;

final class Feed implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $type,
        public string $name,
        public string $mappingIdentifier,
        public string $mediaProvider,
        public Config $config,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'] ?? null,
            $data['type'] ?? null,
            $data['name'] ?? null,
            $data['mappingIdentifier'] ?? null,
            $data['mediaProvider'] ?? null,
            Config::fromArray($data['config'] ?? []),
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'product-feed';
    }
}
