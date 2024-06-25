<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 13.04.22
 */

namespace Rissc\Printformer\Tests\Client;

use GuzzleHttp\Client as HTTPClient;
use GuzzleHttp\Psr7\Uri;
use Nyholm\NSA;
use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Client\ConcreteFactory;
use Rissc\Printformer\Client\Declaration\Ingredient\Proxy as IngredientProxy;
use Rissc\Printformer\Client\Declaration\Proxy as DeclarationProxy;
use Rissc\Printformer\Client\Draft\Proxy as DraftProxy;
use Rissc\Printformer\Client\Factory;
use Rissc\Printformer\Client\MasterTemplate\Proxy as MasterTemplateProxy;
use Rissc\Printformer\Client\User\Proxy as UserProxy;
use Rissc\Printformer\Client\Workflow\Proxy as WorkflowProxy;
use Rissc\Printformer\Client\Processing\Proxy as ProcessingProxy;
use Rissc\Printformer\Client\UserGroup\Proxy as UserGroupProxy;
use Rissc\Printformer\Client\Review\Proxy as ReviewProxy;
use Rissc\Printformer\Client\Feed\Proxy as FeedProxy;
use Rissc\Printformer\Client\Tenant\Proxy as TenantProxy;
use Rissc\Printformer\Client\Theme\Proxy as ThemeProxy;
use Rissc\Printformer\Client\File\Proxy as FileProxy;
use Rissc\Printformer\Client\Variant\Proxy as VariantProxy;

class FactoryTest extends TestCase
{
    public function testConstruct(): Factory
    {
        $factory = new ConcreteFactory([
            'base_uri' => 'https://printformer.test',
            'identifier' => 'test api identifier',
            'api_key' => 'test api token'
        ]);
        /** @var HTTPClient $http */
        $http = NSA::getProperty($factory, 'http');
        /** @var array $config */
        $config = NSA::getProperty($http, 'config');
        /** @var Uri $baseUri */
        $baseUri = $config['base_uri'];

        static::assertEquals('https://printformer.test/api-ext/', (string)$baseUri);
        static::assertEquals([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer test api token',
            'User-Agent' => 'GuzzleHttp/7'
        ], $config['headers']);

        return $factory;
    }

    public function methodToExpectedProvider(): \Generator
    {
        yield 'User' => ['user', UserProxy::class];
        yield 'UserGroup' => ['userGroup', UserGroupProxy::class];
        yield 'MasterTemplate' => ['masterTemplate', MasterTemplateProxy::class];
        yield 'Workflow' => ['workflow', WorkflowProxy::class];
        yield 'Processing' => ['processing', ProcessingProxy::class];
        yield 'Review' => ['review', ReviewProxy::class];
        yield 'Feed' => ['feed', FeedProxy::class];
        yield 'Draft' => ['draft', DraftProxy::class];
        yield 'File' => ['file', FileProxy::class];
        yield 'Tenant' => ['tenant', TenantProxy::class];
        yield 'Variant' => ['variant', VariantProxy::class];
        yield 'Theme' => ['theme', ThemeProxy::class];
        yield 'Declaration' => ['declaration', DeclarationProxy::class];
        yield 'Ingredient' => ['ingredient', IngredientProxy::class];
    }

    /**
     * @depends      testConstruct
     * @dataProvider methodToExpectedProvider
     */
    public function testMake(string $method, string $expected, Factory $factory): void
    {
        static::assertInstanceOf($expected, $factory->$method());
    }
}
