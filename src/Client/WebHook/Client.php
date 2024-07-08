<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 08.07.24
 */

namespace Rissc\Printformer\Client\WebHook;

use Rissc\Printformer\Client\DestroysResources;
use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<WebHook>
 */
class Client extends ResourceClient implements WebHookClient
{
    /** @use ListsResources<WebHook> */
    use ListsResources;
    use DestroysResources;

    protected static string $resource = WebHook::class;

    public function create(array $data): WebHook
    {
        return $this->createResource($data);
    }

    public function show(WebHook|string $webHook): WebHook
    {
        return $this->showResource($webHook);
    }
}
