<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\UserGroup;

use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 */
class Client extends ResourceClient implements UserGroupClient
{
    /** @var class-string<Resource> */
    protected static string $resource = UserGroup::class;

    public function create(): UserGroup
    {
        return self::resourceFromResponse($this->http->post(UserGroup::getPath()));
    }

    public function show(string $identifier): UserGroup
    {
        return $this->showResource($identifier);
    }
}
