<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;
use function data_get;

/** @implements \ArrayAccess<string, mixed> */
final class MasterTemplate implements Resource
{
    use AccessPropertiesAsArray;

    public function __construct(
        public string         $identifier,
        public string         $name,
        public array          $intents,
        public int            $pageCount,
        public ?AvailTemplate $availTemplate,
        public ?array         $groupMembers,
        public ?AvailTemplate $correctionTemplate,
        public array          $customAttributes,
        public string         $updatedAt
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'identifier'),
            data_get($data, 'name'),
            data_get($data, 'intents'),
            data_get($data, 'pageCount'),
            transform(
                data_get($data, 'availTemplate'),
                static fn(array $availTemplate): AvailTemplate => AvailTemplate::fromArray($availTemplate)
            ),
            transform(
                data_get($data, 'groupMembers'),
                static fn(array $groupMembers): array => array_map(static fn(array $groupMember): GroupMember => GroupMember::fromArray($groupMember), $groupMembers)),
            transform(
                data_get($data, 'correctionTemplate'),
                static fn(array $availTemplate): AvailTemplate => AvailTemplate::fromArray($availTemplate)
            ),
            data_get($data, 'customAttributes'),
            data_get($data, 'updatedAt'),
        );
    }

    public static function getPath(): string
    {
        return 'template';
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
