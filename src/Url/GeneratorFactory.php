<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Url;

use Illuminate\Config\Repository;

final class GeneratorFactory
{
    public function __construct(private Repository $config)
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

    public function templateFiles(): TemplateFiles
    {
        return new TemplateFiles($this->config, new TokenBuilder($this->config));
    }
}
