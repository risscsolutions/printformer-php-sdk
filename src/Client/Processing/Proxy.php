<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements ProcessingClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private ProcessingClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(array $drafts, ?string $callbackUrl = null): Processing
    {
        return $this->wrap(fn(): Processing => $this->client->create($drafts, $callbackUrl));
    }

    public function show(string|Processing $processing): Processing
    {
        return $this->wrap(fn(): Processing => $this->client->show($processing));
    }
}
