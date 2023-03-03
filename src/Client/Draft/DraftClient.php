<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use Rissc\Printformer\Client\Feed\Feed;
use Rissc\Printformer\Client\MasterTemplate\GroupMember;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplate;
use Rissc\Printformer\Client\ProvidesListing;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Client\UserGroup\UserGroup;
use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;
use Rissc\Printformer\Exceptions\ValidationException;

/**
 * @extends ProvidesListing<Draft>
 */
interface DraftClient extends ProvidesListing
{
    /**
     * Creates a new Draft
     * @param array{
     *     intent: string,
     *     templateIdentifier: string|MasterTemplate,
     *     user_identifier: string|User,
     *     userGroupIdentifier?: string|UserGroup,
     *     apiDefaultValues?: array<string, mixed>,
     *     customAttributes?: array<string, scalar>,
     *     pagePlanner?: bool,
     *     feedIdentifier?: string|Feed,
     *     availableVariants?: array<string|int>,
     *     availableVariantVersions?: array<string>,
     *     variant?: int,
     *     version?: int,
     *     remoteAcl?: bool,
     *     locked?: bool,
     *     disablePreflight?: bool,
     *     pageFillColor?: string,
     *     spineWidth?: float,
     *     unit?: string,
     *     theme?: string,
     *     pageDimensions?: array<array{width: float, height: float}>,
     *     bleedAdditions?: array{left:float, right:float, top: float, right: float},
     *     defaultGroupTemplate?: string|GroupMember|MasterTemplate,
     *     containerContentPreFilling?: array<array{containerIdentifier: string, catalogTemplateIdentifier: string, pageNumber: int}>,
     *     availableCatalogTemplates?: array<string>
     * } $data
     * @return Draft
     * @throws MaintenanceException|TooManyRequestsException|NotFoundException|ValidationException
     */
    public function create(array $data): Draft;

    public function show(string|Draft $draft): Draft;

    /** @param array{
     *     variant?: int,
     *     version?: int,
     *     apiDefaultValues?: array<string, mixed>,
     *     customAttributes?: array<string, scalar>,
     *     availableCatalogTemplates?: array<string>
     * } $data
     */
    public function update(string|Draft $draft, array $data): Draft;

    public function destroy(string|Draft $draft): bool;

    /** @param array{
     *     pagePlanner?: array{
     *      projectCode: string,
     *      projectName: string,
     *     },
     *     apiDefaultValues?: array<string, mixed>,
     *     customAttributes?: array<string, scalar>,
     *     draftParameter?: array<string, scalar>
     * } $data
     */
    public function replicate(string|Draft $draft, array $data): Draft;

    /**
     * @param array<string|Draft> $drafts
     * @return array<string, bool>
     */
    public function claim(string|User $user, array $drafts, bool $dryRun = false): array;

    public function pageInfo(string|Draft $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo;

    public function requestIdmlPackage(string|Draft $draft, string $callbackURL): bool;
}
