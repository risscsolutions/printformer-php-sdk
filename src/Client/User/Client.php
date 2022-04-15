<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 26.03.22
 */

namespace Rissc\Printformer\Client\User;

use Rissc\Printformer\Client\DestroysResources;
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Exceptions\SuccessFalseException;
use GuzzleHttp\Utils;

/**
 * @internal
 */
class Client extends ResourceClient implements UserClient
{
    use DestroysResources;

    protected static string $resource = User::class;

    public function create(array $data): User
    {
        return $this->createResource($data);
    }

    public function show(string|User $user): User
    {
        return $this->showResource($user);
    }

    public function update(string|User $user, array $data): User
    {
        return $this->updateResource($user, $data);
    }

    public function merge(string|User $targetUser, string|User $sourceUser): User
    {
        $mergeResponse = $this->post(
            $this->buildPath($targetUser, 'merge'),
            ['source_user_identifier' => static::unwrapResource($sourceUser)]
        );
        if (Utils::jsonDecode($mergeResponse->getBody()->getContents())->success === false) {
            throw new SuccessFalseException();
        }
        return $this->show($targetUser);
    }
}
