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
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements MasterTemplateClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private MasterTemplateClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function list(int $page, int $perPage = 25): Paginator
    {
        return $this->wrap(fn(): Paginator => $this->client->list($page, $perPage));
    }

    public function show(string|MasterTemplate $template): MasterTemplate
    {
        return $this->wrap(fn(): MasterTemplate => $this->client->show($template));
    }
}
