<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use function data_get;

class MasterTemplate
{
    public function __construct(
        public string $identifier,
        public string $name,
        public array  $intents,
        public int    $pageCount,
        public ?array  $availTemplate,
        public ?array $groupMembers,
        public ?array  $correctionTemplate,
        public array  $customAttributes,
        public string $updatedAt
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new MasterTemplate(
            data_get($data, 'identifier'),
            data_get($data, 'name'),
            data_get($data, 'intents'),
            data_get($data, 'pageCount'),
            data_get($data, 'availTemplate'),
            data_get($data, 'groupMembers'),
            data_get($data, 'correctionTemplate'),
            data_get($data, 'customAttributes'),
            data_get($data, 'updatedAt'),
        );
    }
}
