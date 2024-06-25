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
use Rissc\Printformer\Client\MasterTemplate\MasterTemplate;

final class TemplateFiles extends Files
{
    protected static string $resource = MasterTemplate::class;

    private ?int $page = null;
    private ?int $variantVersionID = null;

    public function variantExport(string|MasterTemplate $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = $this->buildPath($template, 'variant-export');
        return $this;
    }

    public function variantThumb(string|MasterTemplate $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = $this->buildPath($template, 'variant-thumb');
        return $this;
    }

    public function photoThumb(string|MasterTemplate $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = $this->buildPath($template, 'photo-thumb');
        return $this;
    }

    public function pagePreviewThumb(string|MasterTemplate $template): TemplateFiles
    {
        $this->tokenBuilder->urlPath = $this->buildPath($template, 'page-preview-thumb');
        return $this;
    }

    public function threeDeeTexture(string|MasterTemplate $template, int $pageNumber = 1): TemplateFiles
    {
        $this->tokenBuilder->urlPath = $this->buildPath($template, sprintf('3d-texture/%s', $pageNumber));
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
        return (new Uri($this->config['base_uri']))
            ->withPath($this->tokenBuilder->urlPath)
            ->withQuery(self::buildQuery([
                'jwt' => (string)$this->tokenBuilder,
                'page' => $this->page,
                'variant_version_id' => $this->variantVersionID,
            ]));
    }
}
