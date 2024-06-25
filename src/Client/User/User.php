<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 26.03.22
 */

namespace Rissc\Printformer\Client\User;

use Rissc\Printformer\Util\AccessPropertiesAsArray;
use Rissc\Printformer\Client\Resource;

final class User implements Resource
{
    use AccessPropertiesAsArray;

    /**
     * @param array<string, scalar> $customAttributes
     */
    public function __construct(
        public string  $identifier,
        public ?string $locale,
        public ?string $salutation,
        public ?string $title,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        /** @var array<string, scalar> $customAttributes */
        public array   $customAttributes
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data ['identifier'] ?? null,
            $data ['locale'] ?? null,
            $data ['profile']['salutation'] ?? null,
            $data ['profile']['title'] ?? null,
            $data ['profile']['firstName'] ?? null,
            $data ['profile']['lastName'] ?? null,
            $data ['profile']['email'] ?? null,
            $data ['customAttributes'] ?? [],
        );
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function getPath(): string
    {
        return 'user';
    }
}
