<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer;

use Rissc\Printformer\Acl\Handler;
use Rissc\Printformer\Url\GeneratorFactory;
use Rissc\Printformer\Url\TokenBuilder;
use Illuminate\Config\Repository;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Printformer
{
    private Repository $config;

    #[Pure]
    #[ArrayShape(['base_uri' => 'string', 'identifier' => 'string', 'api_key' => 'string',])]
    public function __construct(array $config)
    {
        $this->config = new Repository($config);
    }

    #[Pure] public function tokenBuilder(): TokenBuilder
    {
        return new TokenBuilder($this->config);
    }

    #[Pure] public function urlGenerator(): GeneratorFactory
    {
        return new GeneratorFactory($this->config);
    }

    public function clientFactory(): ClientFactory
    {
        return new ConcreteClientFactory($this->config);
    }

    #[Pure] public function acl(): Handler
    {
        return new Handler();
    }
}
