<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Builder;

use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\Draft\DraftClient;
use Rissc\Printformer\Client\Feed\Feed;
use Rissc\Printformer\Client\MasterTemplate\GroupMember;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplate;
use Rissc\Printformer\Client\Variant\Variant;
use Rissc\Printformer\Util\UnwrapsResourceIdentifier;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Client\UserGroup\UserGroup;

class DraftBuilder
{
    use UnwrapsResourceIdentifier;

    private ?string $intent = null;
    private ?string $templateIdentifier = null;

    private ?string $userIdentifier = null;
    private ?string $userGroupIdentifier = null;

    /** @var array<string, mixed> */
    private array $apiDefaultValues = [];
    /** @var array<string, mixed> */
    private array $customAttributes = [];
    private bool $pagePlanner = false;
    private ?string $feedIdentifier = null;
    /** @var array<int|string>|null */
    private ?array $availableVariants = null;
    /** @var array<int|string>|null */
    private ?array $availableVariantVersions = null;

    private ?string $variant = null;
    private ?string $variantVersion = null;
    private bool $remoteAcl = false;
    private bool $locked = false;
    private bool $disablePreflight = false;

    private ?string $pageFillColor = null;
    private ?float $spineWidth = null;
    /** @var array<array{width: float, height: float}>|null */
    private ?array $pageDimensions = null;
    /** @var array{left: float, right: float, top: float, right: float}|null */
    private ?array $bleedAdditions = nulL;
    private ?string $defaultGroupTemplate = null;
    /** @var array{containerIdentifier: string, catalogTemplateIdentifier :string, pageNumber: int}|null */
    private ?array $containerContentPreFilling = null;
    /** @var array<int|string>|null */
    private ?array $availableCatalogTemplates = null;


    public function __construct(private DraftClient $draftClient)
    {
    }

    public function intent(?string $intent): DraftBuilder
    {
        $this->intent = $intent;
        return $this;
    }

    public function template(string|MasterTemplate|null $template): DraftBuilder
    {
        $this->templateIdentifier = static::unwrapOptionalResource($template);
        return $this;
    }

    public function user(string|User|null $user): DraftBuilder
    {
        $this->userIdentifier = static::unwrapOptionalResource($user);
        return $this;
    }

    public function userGroup(string|UserGroup|null $userGroup): DraftBuilder
    {
        $this->userGroupIdentifier = static::unwrapOptionalResource($userGroup);
        return $this;
    }

    /** @param array<string, mixed> $apiDefaultValues */
    public function apiDefaultValues(array $apiDefaultValues): DraftBuilder
    {
        $this->apiDefaultValues = $apiDefaultValues;
        return $this;
    }

    /** @param array<string, mixed> $customAttributes */
    public function customAttributes(array $customAttributes): DraftBuilder
    {
        $this->customAttributes = $customAttributes;
        return $this;
    }

    public function pagePlanner(bool $pagePlanner): DraftBuilder
    {
        $this->pagePlanner = $pagePlanner;
        return $this;
    }

    public function feed(string|Feed|null $feed): DraftBuilder
    {
        $this->feedIdentifier = static::unwrapOptionalResource($feed);
        return $this;
    }

    /** @param array<int|string>|null $availableVariants */
    public function availableVariants(?array $availableVariants): DraftBuilder
    {
        $this->availableVariants = $availableVariants;
        return $this;
    }

    /** @param array<int|string>|null $availableVariantVersions */
    public function availableVariantVersions(?array $availableVariantVersions): DraftBuilder
    {
        $this->availableVariantVersions = $availableVariantVersions;
        return $this;
    }

    public function variant(string|Variant|null $variant): DraftBuilder
    {
        $this->variant = static::unwrapOptionalResource($variant);
        return $this;
    }

    public function variantVersion(?string $variantVersion): DraftBuilder
    {
        $this->variantVersion = $variantVersion;
        return $this;
    }

    public function remoteAcl(bool $remoteAcl): DraftBuilder
    {
        $this->remoteAcl = $remoteAcl;
        return $this;
    }

    public function locked(bool $locked): DraftBuilder
    {
        $this->locked = $locked;
        return $this;
    }

    public function disablePreflight(bool $disablePreflight): DraftBuilder
    {
        $this->disablePreflight = $disablePreflight;
        return $this;
    }

    public function pageFillColor(?string $pageFillColor): DraftBuilder
    {
        $this->pageFillColor = $pageFillColor;
        return $this;
    }

    public function spineWidth(?float $spineWidth): DraftBuilder
    {
        $this->spineWidth = $spineWidth;
        return $this;
    }

    /** @param array<array{width: float, height: float}>|null $pageDimensions */
    public function pageDimensions(?array $pageDimensions): DraftBuilder
    {
        $this->pageDimensions = $pageDimensions;
        return $this;
    }

    /** @param array{left:float, right:float, top: float, right: float}|null $bleedAdditions */
    public function bleedAdditions(?array $bleedAdditions): DraftBuilder
    {
        $this->bleedAdditions = $bleedAdditions;
        return $this;
    }

    public function defaultGroupTemplate(string|GroupMember|null $defaultGroupTemplate): DraftBuilder
    {
        $this->defaultGroupTemplate = static::unwrapOptionalResource($defaultGroupTemplate);
        return $this;
    }

    /** @param array{containerIdentifier: string, catalogTemplateIdentifier: string, pageNumber: int}|null $containerContentPreFilling */
    public function containerContentPreFilling(?array $containerContentPreFilling): DraftBuilder
    {
        $this->containerContentPreFilling = $containerContentPreFilling;
        return $this;
    }

    /** @param array<int|string>|null $availableCatalogTemplates */
    public function availableCatalogTemplates(?array $availableCatalogTemplates): DraftBuilder
    {
        $this->availableCatalogTemplates = $availableCatalogTemplates;
        return $this;
    }

    public function create(): Draft
    {
        return $this->draftClient->create(array_filter([
            'intent' => $this->intent,
            'templateIdentifier' => $this->templateIdentifier,
            'user_identifier' => $this->userIdentifier,
            'userGroupIdentifier' => $this->userGroupIdentifier,

            'apiDefaultValues' => $this->apiDefaultValues,
            'customAttributes' => $this->customAttributes,

            'pagePlanner' => $this->pagePlanner,
            'feedIdentifier' => $this->feedIdentifier,

            'availableVariants' => $this->availableVariants,
            'availableVariantVersions' => $this->availableVariantVersions,
            'variant' => $this->variant,
            'version' => $this->variantVersion,

            'remoteAcl' => $this->remoteAcl,
            'locked' => $this->locked,
            'disablePreflight' => $this->disablePreflight,

            'pageFillColor' => $this->pageFillColor,
            'spineWidth' => $this->spineWidth,
            'pageDimensions' => $this->pageDimensions,
            'bleedAdditions' => $this->bleedAdditions,
            'defaultGroupTemplate' => $this->defaultGroupTemplate,
            'containerContentPreFilling' => $this->containerContentPreFilling,
            'availableCatalogTemplates' => $this->availableCatalogTemplates,
        ], static fn(mixed $value): bool => $value !== null));
    }
}
