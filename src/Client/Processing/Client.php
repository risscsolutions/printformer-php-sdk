<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 */
class Client extends ResourceClient implements ProcessingClient
{
    protected static string $resource = Processing::class;

    public function create(array $drafts, ?string $callbackUrl = null): Processing
    {
        return $this->createResource(array_filter([
                'draftIds' => $drafts,
                'stateChangedNotifyUrl' => $callbackUrl
            ], static fn(?string $value): bool => !empty($value))
        );
    }

    public function show(string|Processing $processing): Processing
    {
        return $this->showResource($processing);
    }
}
