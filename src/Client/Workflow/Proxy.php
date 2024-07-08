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
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements WorkflowClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private WorkflowClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(string $definitionIdentifier, WorkflowSubject $subject, array $data = []): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->create($definitionIdentifier, $subject, $data));
    }

    public function show(string|Workflow $workflow): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->show($workflow));
    }

    public function update(string|Workflow $workflow, array $data): Workflow
    {
        return $this->wrap(fn(): Workflow => $this->client->update($workflow, $data));
    }
}
