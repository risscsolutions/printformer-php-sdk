<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\UserGroup;

interface UserGroupClient
{
    public function create(): UserGroup;

    public function show(string $identifier): UserGroup;
}
