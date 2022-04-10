<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Url;

use GuzzleHttp\Psr7\Uri;

final class TemplateFiles extends Base
{
    private ?int $page = null;
    private ?int $variantVersionID = null;

    public function variantExport(string $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/template/%s/variant-export', $template);
        return $this;
    }

    public function variantThumb(string $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/template/%s/variant-thumb', $template);
        return $this;
    }

    public function photoThumb(string $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/template/%s/photo-thumb', $template);
        return $this;
    }

    public function pagePreviewThumb(string $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/template/%s/page-preview-thumb', $template);
        return $this;
    }

    public function threeDeeTexture(string $template, int $pageNumber = 1): TemplateFiles
    {
        $this->tokenBuilder->urlPath = sprintf('/api-ext/template/%s/3d-texture/%s', $template, $pageNumber);
        return $this;
    }

    public function page(int $page): TemplateFiles
    {
        $this->page = $page;
        return $this;
    }

    public function variantVersionID(?int $variantVersionID): TemplateFiles
    {
        $this->variantVersionID = $variantVersionID;
        return $this;
    }

    public function __toString(): string
    {
        return (new Uri($this->config->get('base_uri')))
            ->withPath($this->tokenBuilder->urlPath)
            ->withQuery(self::buildQuery([
                'jwt' => (string)$this->tokenBuilder,
                'page' => $this->page,
                'variant_version_id' => $this->variantVersionID,
            ]));
    }
}
