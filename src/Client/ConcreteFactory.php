<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 26.03.22
 */

namespace Rissc\Printformer\Client;

use Rissc\Printformer\Client\Declaration\Client as DeclarationClient;
use Rissc\Printformer\Client\Declaration\DeclarationClient as DeclarationClientContract;
use Rissc\Printformer\Client\Declaration\Ingredient\Client as IngredientClient;
use Rissc\Printformer\Client\Declaration\Ingredient\IngredientClient as IngredientClientContract;
use Rissc\Printformer\Client\Declaration\Ingredient\Proxy as IngredientProxy;
use Rissc\Printformer\Client\Declaration\Proxy as DeclarationProxy;
use Rissc\Printformer\Client\Derivative\Client as DerivativeClient;
use Rissc\Printformer\Client\Derivative\DerivativeClient as DerivativeClientContract;
use Rissc\Printformer\Client\Derivative\Proxy as DerivativeProxy;
use Rissc\Printformer\Client\Draft\Client as DraftClient;
use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\Draft\DraftClient as DraftClientContract;
use Rissc\Printformer\Client\Draft\Proxy as DraftProxy;
use Rissc\Printformer\Client\Feed\Client as FeedClient;
use Rissc\Printformer\Client\Feed\FeedClient as FeedClientContract;
use Rissc\Printformer\Client\Feed\Proxy as FeedProxy;
use Rissc\Printformer\Client\File\Client as FileClient;
use Rissc\Printformer\Client\File\FileClient as FileClientContract;
use Rissc\Printformer\Client\File\Proxy as FileProxy;
use Rissc\Printformer\Client\MasterTemplate\Client as MasterClient;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplateClient as MasterClientContract;
use Rissc\Printformer\Client\MasterTemplate\Proxy as MasterProxy;
use Rissc\Printformer\Client\Processing\Client as ProcessingClient;
use Rissc\Printformer\Client\Processing\ProcessingClient as ProcessingClientContract;
use Rissc\Printformer\Client\Processing\Proxy as ProcessingProxy;
use Rissc\Printformer\Client\Review\Client as ReviewClient;
use Rissc\Printformer\Client\Review\Proxy as ReviewProxy;
use Rissc\Printformer\Client\Review\ReviewClient as ReviewClientContract;
use Rissc\Printformer\Client\Tenant\Client as TenantClient;
use Rissc\Printformer\Client\Tenant\Proxy as TenantProxy;
use Rissc\Printformer\Client\Tenant\TenantClient as TenantClientContract;
use Rissc\Printformer\Client\Theme\Client as ThemeClient;
use Rissc\Printformer\Client\Theme\Proxy as ThemeProxy;
use Rissc\Printformer\Client\Theme\ThemeClient as ThemeClientContract;
use Rissc\Printformer\Client\User\Client as UserClient;
use Rissc\Printformer\Client\User\Proxy as UserProxy;
use Rissc\Printformer\Client\User\UserClient as UserClientContract;
use Rissc\Printformer\Client\UserGroup\Client as UserGroupClient;
use Rissc\Printformer\Client\UserGroup\Proxy as UserGroupProxy;
use Rissc\Printformer\Client\UserGroup\UserGroupClient as UserGroupClientContract;
use Rissc\Printformer\Client\VariableData\Client as VariableDataClient;
use Rissc\Printformer\Client\VariableData\Proxy as VariableDataProxy;
use Rissc\Printformer\Client\VariableData\VariableDataClient as VariableDataClientContract;
use Rissc\Printformer\Client\Variant\VariantClient as VariantClientContract;
use Rissc\Printformer\Client\Variant\Client as VariantClient;
use Rissc\Printformer\Client\Variant\Proxy as VariantProxy;
use Rissc\Printformer\Client\Workflow\Client as WorkflowClient;
use Rissc\Printformer\Client\Workflow\Proxy as WorkflowProxy;
use Rissc\Printformer\Client\Workflow\WorkflowClient as WorkflowClientContract;
use GuzzleHttp\Client as HTTPClient;

final class ConcreteFactory implements Factory
{
    private HTTPClient $http;

    public function __construct(private array $config)
    {
        $this->http = new HTTPClient([
            'base_uri' => sprintf('%s/api-ext/', $this->config['base_uri']),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $this->config['api_key'])
            ]
        ]);
    }

    public function user(): UserClientContract
    {
        return new UserProxy(new BadRequestHandler(), new UserClient($this->http));
    }

    public function userGroup(): UserGroupClientContract
    {
        return new UserGroupProxy(new BadRequestHandler(), new UserGroupClient($this->http));
    }

    public function masterTemplate(): MasterClientContract
    {
        return new MasterProxy(new BadRequestHandler(), new MasterClient($this->http));
    }

    public function draft(): DraftClientContract
    {
        return new DraftProxy(new BadRequestHandler(), new DraftClient($this->http));
    }

    public function workflow(): WorkflowClientContract
    {
        return new WorkflowProxy(new BadRequestHandler(), new WorkflowClient($this->http));
    }

    public function processing(): ProcessingClientContract
    {
        return new ProcessingProxy(new BadRequestHandler(), new ProcessingClient($this->http));
    }

    public function review(): ReviewClientContract
    {
        return new ReviewProxy(new BadRequestHandler(), new ReviewClient($this->http));
    }

    public function feed(): FeedClientContract
    {
        return new FeedProxy(new BadRequestHandler(), new FeedClient($this->http));
    }

    public function file(): FileClientContract
    {
        return new  FileProxy(new BadRequestHandler(), new FileClient($this->http));
    }

    public function tenant(): TenantClientContract
    {
        return new TenantProxy(new BadRequestHandler(), new TenantClient($this->http));
    }

    public function theme(): ThemeClientContract
    {
        return new ThemeProxy(new BadRequestHandler(), new ThemeClient($this->http));
    }

    public function variableData(string|Draft $draft): VariableDataClientContract
    {
        return new VariableDataProxy(new BadRequestHandler(), new VariableDataClient($this->http, $draft));
    }

    public function derivative(Resource $owner): DerivativeClientContract
    {
        return new DerivativeProxy(new BadRequestHandler(), new DerivativeClient($this->http, $owner));
    }

    public function variant(): VariantClientContract
    {
        return new VariantProxy(new BadRequestHandler(), new VariantClient($this->http));
    }

    public function declaration(): DeclarationClientContract
    {
        return new DeclarationProxy(new BadRequestHandler(), new DeclarationClient($this->http));
    }

    public function ingredient(): IngredientClientContract
    {
        return new IngredientProxy(new BadRequestHandler(), new IngredientClient($this->http));
    }
}
