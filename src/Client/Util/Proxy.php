<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 18.07.24
 */

namespace Rissc\Printformer\Client\Util;

use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;

class Proxy extends Base implements UtilClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private UtilClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function reAssemble(array $drafts, string $callbackURL): string
    {
        return $this->wrap(fn(): string => $this->client->reAssemble($drafts, $callbackURL));
    }
}
