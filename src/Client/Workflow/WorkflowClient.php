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
    #[ArrayShape(['definitionIdentifier' => 'string', 'data' => 'array', 'subject' => ['type' => 'string', 'identifier' => 'string']])]
    public function create(array $data): Workflow;

    public function show(string $identifier): Workflow;

    #[ArrayShape(['data' => 'array'])]
    public function update(string $identifier, array $data): Workflow;
}
