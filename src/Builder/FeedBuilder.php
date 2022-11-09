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

    /** @var ?array{
     *     separator: string,
     *     parseHTML: bool,
     *     offset: int,
     *     identifierAttribute: string,
     *     polling: array{
     *      enabled: bool,
     *      interval: int,
     *      dropBeforeImport: bool
     *     }
     * }
     */
    private ?array $config = null;

    /** @var ?array{
     *     host: string,
     *     username: string,
     *     password: string,
     *     path: string,
     *     port: int,
     *     passive: bool
     * }
     */
    private ?array $ftp = null;

    /** @var ?array{
     *     host: string,
     *     username: string,
     *     password: string,
     *     path: string,
     *     port: int,
     *     passive: bool
     * }
     */
    private ?array $sftp = null;
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

    public function shouldReplicate(?bool $shouldReplicate): FeedBuilder
    {
        $this->shouldReplicate = $shouldReplicate;
        return $this;
    }

    /** @param array{
     *     separator: string,
     *     parseHTML: bool,
     *     offset: int,
     *     identifierAttribute: string,
     *     polling: array{
     *      enabled: bool,
     *      interval: int,
     *      dropBeforeImport: bool
     *     }
     * } $config
     */
    public function config(array $config): FeedBuilder
    {
        $this->config = $config;
        return $this;
    }

    public function file(string|File $file): FeedBuilder
    {
        $this->file = static::unwrapResource($file);
        $this->type = 'local';
        return $this;
    }

    public function url(string $url): FeedBuilder
    {
        $this->url = $url;
        $this->type = 'url';
        return $this;
    }

    /** @param array{
     *     host: string,
     *     username: string,
     *     password: string,
     *     path: string,
     *     port: int,
     *     passive: bool
     * } $ftp
     */
    public function ftp(array $ftp): FeedBuilder
    {
        $this->ftp = $ftp;
        $this->type = 'ftp';
        return $this;
    }

    /** @param array{
     *     host: string,
     *     username: string,
     *     password: string,
     *     path: string,
     *     port: int,
     *     passive: bool
     * } $sftp
     */
    public function sftp(array $sftp): FeedBuilder
    {
        $this->sftp = $sftp;
        $this->type = 'sftp';
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
            'config' => $this->config,
            'ftp' => $this->ftp,
            'sftp' => $this->sftp,
            'file' => $this->file,
            'url' => $this->url,
        ], static fn(mixed $value): bool => $value !== null));
    }
}
