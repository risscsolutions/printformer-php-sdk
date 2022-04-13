<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 26.03.22
 */

namespace Rissc\Printformer\Client;

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
use Rissc\Printformer\Client\User\Client as UserClient;
use Rissc\Printformer\Client\User\Proxy as UserProxy;
use Rissc\Printformer\Client\User\UserClient as UserClientContract;
use Rissc\Printformer\Client\UserGroup\Client as UserGroupClient;
use Rissc\Printformer\Client\UserGroup\Proxy as UserGroupProxy;
use Rissc\Printformer\Client\UserGroup\UserGroupClient as UserGroupClientContract;
use Rissc\Printformer\Client\VariableData\Client as VariableDataClient;
use Rissc\Printformer\Client\VariableData\Proxy as VariableDataProxy;
use Rissc\Printformer\Client\VariableData\VariableDataClient as VariableDataClientContract;
use Rissc\Printformer\Client\Workflow\Client as WorkflowClient;
use Rissc\Printformer\Client\Workflow\Proxy as WorkflowProxy;
use Rissc\Printformer\Client\Workflow\WorkflowClient as WorkflowClientContract;
use GuzzleHttp\Client as HTTPClient;
use Illuminate\Config\Repository;
use JetBrains\PhpStorm\Pure;

final class ConcreteFactory implements Factory
{
    private HTTPClient $http;

    public function __construct(private Repository $config)
    {
        $this->http = new HTTPClient([
            'base_uri' => sprintf('%s/api-ext/', $this->config->get('base_uri')),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $this->config->get('api_key'))
            ]
        ]);
    }

    #[Pure] public function user(): UserClientContract
    {
        return new UserProxy(new BadRequestHandler(), new UserClient($this->http));
    }

    #[Pure] public function userGroup(): UserGroupClientContract
    {
        return new UserGroupProxy(new BadRequestHandler(), new UserGroupClient($this->http));
    }

    #[Pure] public function masterTemplate(): MasterClientContract
    {
        return new MasterProxy(new BadRequestHandler(), new MasterClient($this->http));
    }

    #[Pure] public function draft(): DraftClientContract
    {
        return new DraftProxy(new BadRequestHandler(), new DraftClient($this->http));
    }

    #[Pure] public function workflow(): WorkflowClientContract
    {
        return new WorkflowProxy(new BadRequestHandler(), new WorkflowClient($this->http));
    }

    #[Pure] public function processing(): ProcessingClientContract
    {
        return new ProcessingProxy(new BadRequestHandler(), new ProcessingClient($this->http));
    }

    #[Pure] public function review(): ReviewClientContract
    {
        return new ReviewProxy(new BadRequestHandler(), new ReviewClient($this->http));
    }

    #[Pure] public function feed(): FeedClientContract
    {
        return new FeedProxy(new BadRequestHandler(), new FeedClient($this->http));
    }

    #[Pure] public function file(): FileClientContract
    {
        return new  FileProxy(new BadRequestHandler(), new FileClient($this->http));
    }

    #[Pure] public function tenant(): TenantClientContract
    {
        return new TenantProxy(new BadRequestHandler(), new TenantClient($this->http));
    }

    #[Pure] public function variableData(string|Draft $draft): VariableDataClientContract
    {
        return new VariableDataProxy(new BadRequestHandler(), new VariableDataClient($this->http, $draft));
    }

    #[Pure] public function derivative(Resource $owner): DerivativeClientContract
    {
        return new DerivativeProxy(new BadRequestHandler(), new DerivativeClient($this->http, $owner));
    }
}
