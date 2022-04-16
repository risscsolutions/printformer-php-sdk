<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\User;

interface UserClient
{
    /** @param array{
     *     email: string,
     *     firstName: string,
     *     lastName: string,
     *     title: string,
     *     salutation: string,
     *     customAttributes: array<string, scalar>,
     *     locale: string
     * } $data
     */
    public function create(array $data): User;

    public function show(string|User $user): User;

    /** @param array{
     *     email: string,
     *     firstName: string,
     *     lastName: string,
     *     title: string,
     *     salutation: string,
     *     customAttributes: array<string, scalar>,
     *     locale: string
     * } $data
     */
    public function update(string|User $user, array $data): User;

    public function destroy(string|User $user): bool;

    public function merge(string|User $targetUser, string|User $sourceUser): User;
}
