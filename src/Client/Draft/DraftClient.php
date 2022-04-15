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
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;
use Rissc\Printformer\Exceptions\ValidationException;

/**
 * @extends ResourceClient<Draft>
 */
interface DraftClient
{
    /**
     * Creates a new Draft
     * @param array $data
     * @return Draft
     * @throws MaintenanceException|TooManyRequestsException|NotFoundException|ValidationException
     */
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

    public function show(string|Draft $draft): Draft;

    public function update(string|Draft $draft, array $data): Draft;

    public function destroy(string|Draft $draft): bool;

    #[ArrayShape([
        'pagePlanner' => [
            'projectCode' => 'string',
            'projectName' => 'string',
        ],
        'apiDefaultValues' => 'array',
        'customAttributes' => 'array',
        'draftParameter' => 'array',
    ])]
    public function replicate(string|Draft $draft, array $data): Draft;

    public function claim(string|User $user, array $drafts, bool $dryRun = false): array;

    public function pageInfo(string|Draft $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo;

    public function requestIdmlPackage(string|Draft $draft, string $callbackURL): bool;
}
