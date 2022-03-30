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
use function data_get;

class Workflow
{
    public function __construct(
        public string  $identifier,
        public array   $data,
        public ?string $definitionIdentifier,
                       #[ArrayShape(['type' => 'string', 'identifier' => 'string'])]
        public array $subject
    )
    {
    }

    public function get(string $key): mixed
    {
        return data_get($this->data, $key);
    }

    public static function fromArray(array $data): Workflow
    {
        return new Workflow(
            data_get($data, 'identifier'),
            data_get($data, 'data'),
            data_get($data, 'definitionIdentifier'),
            data_get($data, 'subject'),
        );
    }
}
