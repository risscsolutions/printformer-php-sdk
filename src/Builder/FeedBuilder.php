<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 14.04.22
 */

namespace Rissc\Printformer\Builder;

use Rissc\Printformer\Client\Feed\Config;
use Rissc\Printformer\Client\Feed\Feed;
use Rissc\Printformer\Client\Feed\FeedClient;
use Rissc\Printformer\Client\File\File;
use Rissc\Printformer\Util\UnwrapsResourceIdentifier;

class FeedBuilder
{
    use UnwrapsResourceIdentifier;

    private ?string $name = null;
    private ?string $mappingIdentifier = null;
    private ?string $mediaProvider = null;
    private ?string $type = null;
    private ?bool $shouldReplicate = null;
    private ?Config $config = null;
    private ?string $file = null;
    private ?string $url = null;

    public function __construct(private FeedClient $feedClient)
    {
    }

    public function name(?string $name): FeedBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function mappingIdentifier(?string $mappingIdentifier): FeedBuilder
    {
        $this->mappingIdentifier = $mappingIdentifier;
        return $this;
    }

    public function mediaProvider(?string $mediaProvider): FeedBuilder
    {
        $this->mediaProvider = $mediaProvider;
        return $this;
    }

    public function type(?string $type): FeedBuilder
    {
        $this->type = $type;
        return $this;
    }

    public function shouldReplicate(?bool $shouldReplicate): FeedBuilder
    {
        $this->shouldReplicate = $shouldReplicate;
        return $this;
    }

    public function config(?Config $config): FeedBuilder
    {
        $this->config = $config;
        return $this;
    }

    public function file(null|string|File $file): FeedBuilder
    {
        $this->file = static::unwrapOptionalResource($file);
        return $this;
    }

    public function url(?string $url): FeedBuilder
    {
        $this->url = $url;
        return $this;
    }

    public function create(): Feed
    {
        return $this->feedClient->create(array_filter([
            'name' => $this->name,
            'mappingIdentifier' => $this->mappingIdentifier,
            'mediaProvider' => $this->mediaProvider,
            'type' => $this->type,
            'shouldReplicate' => $this->shouldReplicate,
            'config' => (array)$this->config,
            'file' => $this->file,
            'url' => $this->url,
        ], static fn($value): bool => $value !== null));
    }
}
