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
use Rissc\Printformer\Client\Draft\Draft;

final class DraftFiles extends Files
{
    protected static string $resource = Draft::class;

    private ?int $row = null;
    private ?string $usage = null;
    private ?int $width = null;
    private ?int $height = null;
    private ?int $page = null;

    public function idmlPackage(string|Draft $draft): self
    {
        $this->tokenBuilder->urlPath = $this->buildPath($draft, 'idml-package');
        return $this;
    }

    public function printFile(string|Draft $draft): self
    {
        $this->tokenBuilder->urlPath = $this->buildPath($draft, 'print');
        return $this;
    }

    public function preview(string|Draft $draft): self
    {
        $this->tokenBuilder->urlPath = $this->buildPath($draft, 'low-res');
        return $this;
    }

    public function image(string|Draft $draft): self
    {
        $this->tokenBuilder->urlPath = $this->buildPath($draft, 'image');
        return $this;
    }

    public function x3d(string|Draft $draft): self
    {
        $this->tokenBuilder->urlPath = $this->buildPath($draft, 'x3d');
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
