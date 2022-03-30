<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Workflow;

use JetBrains\PhpStorm\ArrayShape;

interface WorkflowClient
{
    public function create(string $definitionIdentifier, array $subject, array $data = []): Workflow;

    public function show(string $identifier): Workflow;

    #[ArrayShape(['data' => 'array'])]
    public function update(string $identifier, array $data): Workflow;
}
