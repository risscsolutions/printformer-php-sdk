<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 09.11.22
 */

namespace Rissc\Printformer\Url;

use GuzzleHttp\Psr7\Uri;
use Rissc\Printformer\Client\Derivative\Derivative;

final class DerivativeFiles extends Files
{
    protected static string $resource = Derivative::class;

    private ?int $page = null;

    public function file(string|Derivative $derivative): self
    {
        $this->tokenBuilder->urlPath = $this->buildPath($derivative, 'file');
        return $this;
    }

    public function page(?int $page = null): self
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
                'page' => $this->page,
            ]));
    }
}
