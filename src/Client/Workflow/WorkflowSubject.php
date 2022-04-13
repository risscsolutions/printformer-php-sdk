<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Workflow;

use Rissc\Printformer\Util\AccessPropertiesAsArray;

class WorkflowSubject implements \ArrayAccess
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
        return new WorkflowSubject(
            data_get($data, 'type'),
            data_get($data, 'identifier'),
        );
    }
}
