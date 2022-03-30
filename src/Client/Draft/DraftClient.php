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

interface DraftClient
{
    #[ArrayShape([
        'intent' => 'string',
        'templateIdentifier' => 'string',
        'user_identifier' => 'string',
        'userGroupIdentifier' => 'string',

        'apiDefaultValues' => 'array',
        'customAttributes' => 'array',

        'pagePlanner' => 'bool',
        'feedIdentifier' => 'string',

        'availableVariants' => 'array',
        'availableVariantVersions' => 'array',
        'variant' => 'int',
        'version' => 'int',

        'remoteAcl' => 'bool',
        'locked' => 'bool',
        'disablePreflight' => 'bool',

        'pageFillColor' => 'string',
        'spineWidth' => 'string',
        'pageDimensions' => [
            ['width' => 'float', 'height' => 'float']
        ],
        'bleedAdditions' => [
            'top' => 'float',
            'bottom' => 'float',
            'left' => 'float',
            'right' => 'float',
        ],
        'defaultGroupTemplate' => 'string',
        'containerContentPreFilling' => [[
            'containerIdentifier' => 'string',
            'pageNumber' => 'int',
            'catalogTemplateIdentifier' => 'string'
        ]],
        'availableCatalogTemplates' => 'array',

    ])]
    public function create(array $data): Draft;

    public function show(string $identifier): Draft;

    public function update(string $identifier, array $data): Draft;

    public function destroy(string $identifier): bool;

    #[ArrayShape([
        'pagePlanner' => [
            'projectCode' => 'string',
            'projectName' => 'string',
        ],
        'apiDefaultValues' => 'array',
        'customAttributes' => 'array',
        'draftParameter' => 'array',

    ])]
    public function replicate(string $identifier, array $data): Draft;

    public function claim(string $user, array $identifiers, bool $dryRun = false): array;

    public function pageInfo(string $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo;

    public function requestIdmlPackage(string $draft, string $callbackURL): bool;

    //TODO VARIABLE DATA
}
