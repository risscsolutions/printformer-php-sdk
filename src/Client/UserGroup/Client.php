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
 * @extends ResourceClient<UserGroup>
 */
class Client extends ResourceClient implements UserGroupClient
{
    protected static string $resource = UserGroup::class;

    public function create(): UserGroup
    {
        return self::resourceFromResponse($this->http->request('POST', $this->path));
    }

    public function show(string|UserGroup $userGroup): UserGroup
    {
        return $this->showResource($userGroup);
    }
}
