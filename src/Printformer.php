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
use Rissc\Printformer\Builder\ConcreteFactory as ConcreteBuilderFactory;
use Rissc\Printformer\Builder\Factory as BuilderFactory;
use Rissc\Printformer\Client\Factory as ClientFactory;
use Rissc\Printformer\Client\ConcreteFactory as ConcreteClientFactory;
use Rissc\Printformer\Url\GeneratorFactory;
use Rissc\Printformer\Url\TokenBuilder;
use JetBrains\PhpStorm\Pure;

final class Printformer
{
    /** @param array{base_uri: string, identifier: string, api_key: string} $config */
    #[Pure]
    public function __construct(private array $config)
    {
    }

    #[Pure]
    public function tokenBuilder(): TokenBuilder
    {
        return new TokenBuilder($this->config);
    }

    #[Pure]
    public function urlGenerator(): GeneratorFactory
    {
        return new GeneratorFactory($this->config);
    }

    public function clientFactory(): ClientFactory
    {
        return new ConcreteClientFactory($this->config);
    }

    #[Pure]
    public function acl(): Handler
    {
        return new Handler();
    }

    #[Pure]
    public function builderFactory(): BuilderFactory
    {
        return new ConcreteBuilderFactory($this);
    }

    public function validateConfiguration(): bool
    {
        return $this->clientFactory()->tenant()->show()->identifier === $this->config->get('identifier');
    }
}
