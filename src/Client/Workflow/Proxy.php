<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Workflow;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Proxy extends Base implements WorkflowClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private Client $client)
    {
        parent::__construct($badRequestHandler);
    }

    #[ArrayShape(['definitionIdentifier' => 'string', 'data' => 'array', 'subject' => ['type' => 'string', 'identifier' => 'string']])]
    public function create(array $data): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->create($data));
    }

    public function show(string $identifier): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->show($identifier));
    }

    #[ArrayShape(['data' => 'array'])]
    public function update(string $identifier, array $data): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->update($identifier, $data));
    }
}
