<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Workflow;

use Rissc\Printformer\Client\Client as Base;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class Client extends Base implements WorkflowClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'workflow');
    }

    public function create(string $definitionIdentifier, array $subject, array $data = []): Workflow
    {
        return self::workflowFromResponse($this->post($this->resource, compact('definitionIdentifier', 'subject', 'data')));
    }

    public function show(string $identifier): Workflow
    {
        return self::workflowFromResponse($this->get($this->buildPath($identifier)));
    }

    public function update(string $identifier, array $data): Workflow
    {
        return self::workflowFromResponse($this->put($this->buildPath($identifier), compact('data')));
    }

    private static function workflowFromResponse(ResponseInterface $response): Workflow
    {
        return Workflow::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
