<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Workflow;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\Util;

final class Workflow implements Resource
{
    use AccessPropertiesAsArray;

    /** @param array<string, mixed> $data */
    public function __construct(
        public string          $identifier,
        /** @var array<string, mixed> */
        public array           $data,
        public ?string         $definitionIdentifier,
        public WorkflowSubject $subject
    )
    {
    }

    public function get(string $key): mixed
    {
        return Util::get($this->data, $key);
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'] ?? null,
            $data['data'] ?? null,
            $data['definitionIdentifier'] ?? null,
            WorkflowSubject::fromArray($data['subject'] ?? null),
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'workflow';
    }
}
