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

final class MasterTemplate implements Resource
{
    use AccessPropertiesAsArray;

    /**
     * @param array<string> $intents
     * @param array<GroupMember> $groupMembers
     * @param array<string, scalar> $customAttributes
     */
    public function __construct(
        public string         $identifier,
        public string         $name,
        /** @var array<string> $intents */
        public array          $intents,
        public int            $pageCount,
        public ?AvailTemplate $availTemplate,
        /** @var array<GroupMember> $groupMembers */
        public ?array         $groupMembers,
        public ?AvailTemplate $correctionTemplate,
        /** @var array<string, scalar> $customAttributes */
        public array          $customAttributes,
        /** @var array<string> $dataKeys */
        public array          $dataKeys,
        public string         $updatedAt,
        public array          $variants,
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
            data_get($data, 'dataKeys', []),
            data_get($data, 'updatedAt'),
            data_get($data, 'variants', [])
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
