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

    public function show(string $identifier): User;

    #[ArrayShape(['email' => 'string', 'firstName' => 'string', 'lastName' => 'string', 'title' => 'string', 'salutation' => 'string', 'customAttributes' => 'array', 'locale' => 'string',])]
    public function update(string $identifier, array $data): User;

    public function destroy(string $identifier): bool;

    public function merge(string $targetUser, string $sourceUser): User;
}
