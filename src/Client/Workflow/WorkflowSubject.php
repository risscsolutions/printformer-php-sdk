<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Workflow;

use Illuminate\Contracts\Support\Arrayable;
use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Util\AccessPropertiesAsArray;

final class WorkflowSubject implements \ArrayAccess, Arrayable
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string $type,
        public string $identifier
    )
    {
    }

    public static function fromArray(array $data): WorkflowSubject
    {
        return new static(
            data_get($data, 'type'),
            data_get($data, 'identifier'),
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
