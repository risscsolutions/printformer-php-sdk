<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Feed;

class Feed
{
    public function __construct(
        public string $identifier,
        public string $type,
        public string $name,
        public string $mappingIdentifier,
        public string $mediaProvider,
        public array $config,
    )
    {
    }

    public static function fromArray(array $data): Feed
    {
        return new Feed(
            data_get($data, 'identifier'),
            data_get($data, 'type'),
            data_get($data, 'name'),
            data_get($data, 'mappingIdentifier'),
            data_get($data, 'mediaProvider'),
            data_get($data, 'config'),
        );
    }
}
