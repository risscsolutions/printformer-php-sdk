<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Workflow;

use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<Workflow>
 */
class Client extends ResourceClient implements WorkflowClient
{
    protected static string $resource = Workflow::class;

    public function create(string $definitionIdentifier, WorkflowSubject $subject, array $data = []): Workflow
    {
        return $this->createResource(compact('definitionIdentifier', 'subject', 'data'));
    }

    public function show(string|Workflow $workflow): Workflow
    {
        return $this->showResource($workflow);
    }

    public function update(string|Workflow $workflow, array $data): Workflow
    {
        return $this->updateResource($workflow, compact('data'));
    }
}
