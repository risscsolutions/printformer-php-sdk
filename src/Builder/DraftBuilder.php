<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer;

use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\Draft\DraftClient;

class DraftBuilder
{
    private ?string $intent = null;
    private ?string $templateIdentifier = null;

    private ?string $userIdentifier = null;
    private ?string $userGroupIdentifier = null;

    private array $apiDefaultValues = [];
    private array $customAttributes = [];
    private bool $pagePlanner = false;
    private ?string $feedIdentifier = null;
    private ?array $availableVariants = null;
    private ?array $availableVariantVersions = null;

    private ?int $variant = null;
    private ?int $variantVersion = null;
    private bool $remoteAcl = false;
    private bool $locked = false;
    private bool $disablePreflight = false;

    private ?string $pageFillColor = null;
    private ?float $spineWidth = null;
    private ?array $pageDimensions = null;
    private ?array $bleedAdditions = nulL;
    private ?string $defaultGroupTemplate = null;
    private ?array $containerContentPreFilling = null;

    private ?array $availableCatalogTemplates = null;


    public function __construct(private DraftClient $draftClient)
    {
    }

    public function setIntent(?string $intent): DraftBuilder
    {
        $this->intent = $intent;
        return $this;
    }

    public function setTemplateIdentifier(?string $templateIdentifier): DraftBuilder
    {
        $this->templateIdentifier = $templateIdentifier;
        return $this;
    }

    public function setUserIdentifier(?string $userIdentifier): DraftBuilder
    {
        $this->userIdentifier = $userIdentifier;
        return $this;
    }

    public function setUserGroupIdentifier(?string $userGroupIdentifier): DraftBuilder
    {
        $this->userGroupIdentifier = $userGroupIdentifier;
        return $this;
    }

    public function setApiDefaultValues(array $apiDefaultValues): DraftBuilder
    {
        $this->apiDefaultValues = $apiDefaultValues;
        return $this;
    }

    public function setCustomAttributes(array $customAttributes): DraftBuilder
    {
        $this->customAttributes = $customAttributes;
        return $this;
    }

    public function setPagePlanner(bool $pagePlanner): DraftBuilder
    {
        $this->pagePlanner = $pagePlanner;
        return $this;
    }

    public function setFeedIdentifier(?string $feedIdentifier): DraftBuilder
    {
        $this->feedIdentifier = $feedIdentifier;
        return $this;
    }

    public function setAvailableVariants(?array $availableVariants): DraftBuilder
    {
        $this->availableVariants = $availableVariants;
        return $this;
    }

    public function setAvailableVariantVersions(?array $availableVariantVersions): DraftBuilder
    {
        $this->availableVariantVersions = $availableVariantVersions;
        return $this;
    }

    public function setVariant(?int $variant): DraftBuilder
    {
        $this->variant = $variant;
        return $this;
    }

    public function setVariantVersion(?int $variantVersion): DraftBuilder
    {
        $this->variantVersion = $variantVersion;
        return $this;
    }

    public function setRemoteAcl(bool $remoteAcl): DraftBuilder
    {
        $this->remoteAcl = $remoteAcl;
        return $this;
    }

    public function setLocked(bool $locked): DraftBuilder
    {
        $this->locked = $locked;
        return $this;
    }

    public function setDisablePreflight(bool $disablePreflight): DraftBuilder
    {
        $this->disablePreflight = $disablePreflight;
        return $this;
    }

    public function setPageFillColor(?string $pageFillColor): DraftBuilder
    {
        $this->pageFillColor = $pageFillColor;
        return $this;
    }

    public function setSpineWidth(?float $spineWidth): DraftBuilder
    {
        $this->spineWidth = $spineWidth;
        return $this;
    }

    public function setPageDimensions(?array $pageDimensions): DraftBuilder
    {
        $this->pageDimensions = $pageDimensions;
        return $this;
    }

    public function setBleedAdditions(?array $bleedAdditions): DraftBuilder
    {
        $this->bleedAdditions = $bleedAdditions;
        return $this;
    }

    public function setDefaultGroupTemplate(?string $defaultGroupTemplate): DraftBuilder
    {
        $this->defaultGroupTemplate = $defaultGroupTemplate;
        return $this;
    }

    public function setContainerContentPreFilling(?array $containerContentPreFilling): DraftBuilder
    {
        $this->containerContentPreFilling = $containerContentPreFilling;
        return $this;
    }

    public function setAvailableCatalogTemplates(?array $availableCatalogTemplates): DraftBuilder
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
