<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Url;

final class GeneratorFactory
{
    public function __construct(private array $config)
    {
    }

    public function editor(): Editor
    {
        return new Editor($this->config, new TokenBuilder($this->config));
    }

    public function review(): Review
    {
        return new Review($this->config, new TokenBuilder($this->config));
    }

    public function draftFiles(): DraftFiles
    {
        return new DraftFiles($this->config, new TokenBuilder($this->config));
    }

    public function derivativeFiles(): DerivativeFiles
    {
        return new DerivativeFiles($this->config, new TokenBuilder($this->config));
    }

    public function templateFiles(): TemplateFiles
    {
        return new TemplateFiles($this->config, new TokenBuilder($this->config));
    }
}
