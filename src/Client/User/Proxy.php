<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\User;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements UserClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private UserClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(array $data): User
    {
        return $this->wrap(fn(): User => $this->client->create($data));
    }

    public function destroy(string|User $user): bool
    {
        return $this->wrap(fn(): bool => $this->client->destroy($user));
    }

    public function show(string|User $user): User
    {
        return $this->wrap(fn(): User => $this->client->show($user));
    }

    public function update(string|User $user, array $data): User
    {
        return $this->wrap(fn(): User => $this->client->update($user, $data));
    }

    public function merge(string|User $targetUser, string|User $sourceUser): User
    {
        return $this->wrap(fn(): User => $this->client->merge($targetUser, $sourceUser));
    }
}
