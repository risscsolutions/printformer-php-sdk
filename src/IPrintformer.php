<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 06.07.24
 */

namespace Rissc\Printformer;

use Rissc\Printformer\Acl\Handler;
use Rissc\Printformer\Builder\Factory as BuilderFactory;
use Rissc\Printformer\Client\Factory as ClientFactory;
use Rissc\Printformer\Url\GeneratorFactory;
use Rissc\Printformer\Url\TokenBuilder;

interface IPrintformer
{
    public function tokenBuilder(): TokenBuilder;

    public function urlGenerator(): GeneratorFactory;

    public function clientFactory(): ClientFactory;

    public function acl(): Handler;

    public function builderFactory(): BuilderFactory;

    public function validateConfiguration(): bool;
}
