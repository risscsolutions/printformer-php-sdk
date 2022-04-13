<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Workflow;

interface WorkflowClient
{
    public function create(string $definitionIdentifier, array $subject, array $data = []): Workflow;

    public function show(string|Workflow $workflow): Workflow;

    public function update(string|Workflow $workflow, array $data): Workflow;
}
