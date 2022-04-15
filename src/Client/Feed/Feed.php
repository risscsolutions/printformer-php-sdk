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

class Feed implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $identifier,
        public string $type,
        public string $name,
        public string $mappingIdentifier,
        public string $mediaProvider,
        public Config  $config,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'identifier'),
            data_get($data, 'type'),
            data_get($data, 'name'),
            data_get($data, 'mappingIdentifier'),
            data_get($data, 'mediaProvider'),
            Config::fromArray(data_get($data, 'config')),
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
