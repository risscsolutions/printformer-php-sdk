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

/**
 * @internal
 */
class Proxy extends Base implements WorkflowClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private Client $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(string $definitionIdentifier, array $subject, array $data = []): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->create($definitionIdentifier, $subject, $data));
    }

    public function show(string $identifier): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->show($identifier));
    }

    public function update(string $identifier, array $data): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->update($identifier, $data));
    }
}
