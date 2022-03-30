<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\Pure;

class Proxy extends Base implements MasterTemplateClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private MasterTemplateClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function list(?int $page = null): array
    {
        return $this->wrap(fn(): array => $this->client->list($page));
    }
}
