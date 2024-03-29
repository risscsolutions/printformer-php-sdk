<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\UserGroup;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements UserGroupClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private UserGroupClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(): UserGroup
    {
        return $this->wrap(fn(): UserGroup => $this->client->create());
    }

    public function show(string|UserGroup $userGroup): UserGroup
    {
        return $this->wrap(fn(): UserGroup => $this->client->show($userGroup));
    }
}
