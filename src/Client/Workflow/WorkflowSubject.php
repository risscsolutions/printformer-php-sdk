<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Workflow;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

/**
 * @implements \ArrayAccess<string, string>
 */
final class WorkflowSubject implements \ArrayAccess
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $type,
        public string $identifier
    )
    {
    }

    /** @param array{type: string, identifier:string} $data */
    public static function fromArray(array $data): WorkflowSubject
    {
        return new static(
            $data['type'] ?? null,
            $data['identifier'] ?? null,
        );
    }

    public static function fromResource(Resource $resource): WorkflowSubject
    {
        return new WorkflowSubject($resource::getPath(), $resource->getIdentifier());
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'identifier' => $this->identifier,
        ];
    }
}
