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
use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;
use function data_get;

/** @implements \ArrayAccess<string, mixed> */
final class Workflow implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string          $identifier,
        public array           $data,
        public ?string         $definitionIdentifier,
        public WorkflowSubject $subject
    )
    {
    }

    public function get(string $key): mixed
    {
        return data_get($this->data, $key);
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'identifier'),
            data_get($data, 'data'),
            data_get($data, 'definitionIdentifier'),
            WorkflowSubject::fromArray(data_get($data, 'subject')),
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
