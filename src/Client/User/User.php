<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 26.03.22
 */

namespace Rissc\Printformer\Client\User;

use function data_get;

class User
{
    public function __construct(
        public string $identifier,
        public ?string $locale,
        public ?string $salutation,
        public ?string $title,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public array  $customAttributes
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new User(
            data_get($data, 'identifier'),
            data_get($data, 'locale'),
            data_get($data, 'profile.salutation'),
            data_get($data, 'profile.title'),
            data_get($data, 'profile.firstName'),
            data_get($data, 'profile.lastName'),
            data_get($data, 'profile.email'),
            data_get($data, 'customAttributes'),
        );
    }
}
