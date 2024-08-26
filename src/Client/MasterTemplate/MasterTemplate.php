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
        public string         $type,
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
        public ?string        $previewUrl,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['identifier'] ?? null,
            $data['name'] ?? null,
            $data['type'] ?? null,
            $data['intents'] ?? null,
            $data['pageCount'] ?? null,
            isset($data['availTemplate'])
                ? AvailTemplate::fromArray($data['availTemplate'])
                : null,
            isset($data['groupMembers'])
                ? array_map(static fn(array $groupMember): GroupMember => GroupMember::fromArray($groupMember), $data['groupMembers'])
                : [],
            isset($data['correctionTemplate'])
                ? AvailTemplate::fromArray($data['correctionTemplate'])
                : null,
            $data['customAttributes'] ?? null,
            $data['dataKeys'] ?? [],
            $data['updatedAt'] ?? null,
            $data['variants'] ?? [],
            $data['previewUrl'] ?? null
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
