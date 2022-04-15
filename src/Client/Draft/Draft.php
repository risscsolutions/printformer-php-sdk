<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use JetBrains\PhpStorm\ArrayShape;
use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;
use function data_get;

/** @implements Resource<string, mixed> */
final class Draft implements Resource
{
    use AccessPropertiesAsArray;

    /**
     * @param array<ValidationResult> $validationResults
     * @param array{amount: int} $personalizations
     * @param array<string, mixed> $apiDefaultValues
     * @param array<string, scalar> $customAttributes
     */
    public function __construct(
        public string  $userIdentifier,
        public ?string $userGroupIdentifier,
        public string  $templateIdentifier,
        public ?string $activeGroupTemplateIdentifier,
        public string  $draftHash,
        /** @var array{amount: int} $personalizations */
        public array   $personalizations,
        public mixed   $preflightStatus,
        public array   $variant,
        /** @var array<string, mixed> $apiDefaultValues */
        public array   $apiDefaultValues,
        /** @var array<string, scalar> $customAttributes */
        public array   $customAttributes,
        public string  $state,
        public ?string $setupStatus,
        /** @var array<ValidationResult> $validationResults */
        public array   $validationResults,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            data_get($data, 'userIdentifier'),
            data_get($data, 'userGroupIdentifier'),
            data_get($data, 'templateIdentifier'),
            data_get($data, 'activeGroupTemplateIdentifier'),
            data_get($data, 'draftHash'),
            data_get($data, 'personalizations'),
            data_get($data, 'preflightStatus'),
            data_get($data, 'variant'),
            data_get($data, 'apiDefaultValues'),
            data_get($data, 'customAttributes'),
            data_get($data, 'state'),
            data_get($data, 'setupStatus'),
            array_map(static fn(array $result): ValidationResult => ValidationResult::fromArray($result), data_get($data, 'validationResults', []))
        );
    }

    public function getIdentifier(): string
    {
        return $this->draftHash;
    }

    public static function getPath(): string
    {
        return 'draft';
    }
}
