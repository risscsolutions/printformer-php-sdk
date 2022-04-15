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
    /** @param array<string, mixed> $data */
    public function create(string $definitionIdentifier, WorkflowSubject $subject, array $data = []): Workflow;

    public function show(string|Workflow $workflow): Workflow;

    /** @param array<string, mixed> $data */
    public function update(string|Workflow $workflow, array $data): Workflow;
}
