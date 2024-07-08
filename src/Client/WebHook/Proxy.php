<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 08.07.24
 */

namespace Rissc\Printformer\Client\WebHook;

use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;

/**
 * @internal
 */
class Proxy extends Base implements WebHookClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private WebHookClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(array $data = []): WebHook
    {
        return $this->wrap(fn(): WebHook => $this->client->create($data));
    }

    public function show(string|WebHook $webHook): WebHook
    {
        return $this->wrap(fn(): WebHook => $this->client->show($webHook));
    }

    public function destroy(string|WebHook $webHook): bool
    {
        return $this->wrap(fn(): bool => $this->client->destroy($webHook));
    }

}
