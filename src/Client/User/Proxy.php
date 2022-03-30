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

class Proxy extends Base implements UserClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private Client $client)
    {
        parent::__construct($badRequestHandler);
    }

    #[ArrayShape(['email' => 'string', 'firstName' => 'string', 'lastName' => 'string', 'title' => 'string', 'salutation' => 'string', 'customAttributes' => 'array', 'locale' => 'string',])]
    public function create(array $data): User
    {
        return $this->wrap(fn(): User => $this->client->create($data));
    }

    public function destroy(string $identifier): bool
    {
        return $this->wrap(fn(): bool => $this->client->destroy($identifier));
    }

    public function show(string $identifier): User
    {
        return $this->wrap(fn(): User => $this->client->show($identifier));
    }

    #[ArrayShape(['email' => 'string', 'firstName' => 'string', 'lastName' => 'string', 'title' => 'string', 'salutation' => 'string', 'customAttributes' => 'array', 'locale' => 'string',])]
    public function update(string $identifier, array $data): User
    {
        return $this->wrap(fn(): User => $this->client->update($identifier, $data));
    }

    public function merge(string $targetUser, string $sourceUser): User
    {
        return $this->wrap(fn(): User => $this->client->merge($targetUser, $sourceUser));
    }
}
