<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Url;

use GuzzleHttp\Psr7\Uri;

final class DraftFiles extends Base
{
    private ?int $row = null;
    private ?string $usage = null;
    private ?int $width = null;
    private ?int $height = null;
    private ?int $page = null;

    public function idmlPackage(string $draft): self
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/files/draft/%s/idml-package', $draft);
        return $this;
    }

    public function printFile(string $draft): self
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/files/draft/%s/print', $draft);
        return $this;
    }

    public function preview(string $draft): self
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/files/draft/%s/low-res', $draft);
        return $this;
    }

    public function image(string $draft): self
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/files/draft/%s/image', $draft);

        return $this;
    }

    public function x3d(string $draft): self
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/files/draft/%s/x3d', $draft);

        return $this;
    }

    public function width(int $width): DraftFiles
    {
        $this->width = $width;
        return $this;
    }

    public function height(int $height): DraftFiles
    {
        $this->height = $height;
        return $this;
    }

    public function usage(string $usage): DraftFiles
    {
        $this->usage = $usage;
        return $this;
    }

    public function row(int $row): DraftFiles
    {
        $this->row = $row;
        return $this;
    }

    public function page(int $page): DraftFiles
    {
        $this->page = $page;
        return $this;
    }

    public function __toString(): string
    {
        return (new Uri($this->config->get('base_uri')))
            ->withPath($this->tokenBuilder->urlPath)
            ->withQuery(self::buildQuery([
                'jwt' => (string)$this->tokenBuilder,
                'row' => $this->row,
                'usage' => $this->usage,
                'width' => $this->width,
                'height' => $this->height,
                'page' => $this->page,
            ]));
    }
}
