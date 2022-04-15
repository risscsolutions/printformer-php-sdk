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
 * @extends ResourceClient<Processing>
 */
class Client extends ResourceClient implements ProcessingClient
{
    protected static string $resource = Processing::class;

    public function create(array $drafts, ?string $callbackUrl = null): Processing
    {
        $processingId = $this->createResource(array_filter([
                'draftIds' => static::unwrapArray($drafts),
                'stateChangedNotifyUrl' => $callbackUrl
            ], static fn(mixed $value): bool => !empty($value))
        );

        return $this->show($processingId);
    }

    public function show(string|Processing $processing): Processing
    {
        return $this->showResource($processing);
    }
}
