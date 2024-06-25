<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;

final class Draft implements Resource
{
    use AccessPropertiesAsArray;

    /**
     * @param array{id:int, identifier:string, version:int} $variant
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
        public int     $preflightStatus,
        /** @var array{id:int, identifier:string, version:int} $variant */
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
            $data['userIdentifier'] ?? null,
            $data['userGroupIdentifier'] ?? null,
            $data['templateIdentifier'] ?? null,
            $data['activeGroupTemplateIdentifier'] ?? null,
            $data['draftHash'] ?? null,
            $data['personalizations'] ?? null,
            $data['preflightStatus'] ?? null,
            $data['variant'] ?? null,
            $data['apiDefaultValues'] ?? null,
            $data['customAttributes'] ?? null,
            $data['state'] ?? null,
            $data['setupStatus'] ?? null,
            array_map(static fn(array $result): ValidationResult => ValidationResult::fromArray($result), $data['validationResults'] ?? [])
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
