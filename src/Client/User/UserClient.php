<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\User;

use JetBrains\PhpStorm\ArrayShape;

interface UserClient
{
    #[ArrayShape(['email' => 'string', 'firstName' => 'string', 'lastName' => 'string', 'title' => 'string', 'salutation' => 'string', 'customAttributes' => 'array', 'locale' => 'string',])]
    public function create(array $data): User;

    public function show(string|User $user): User;

    #[ArrayShape(['email' => 'string', 'firstName' => 'string', 'lastName' => 'string', 'title' => 'string', 'salutation' => 'string', 'customAttributes' => 'array', 'locale' => 'string',])]
    public function update(string|User $user, array $data): User;

    public function destroy(string|User $user): bool;

    public function merge(string|User $targetUser, string|User $sourceUser): User;
}
