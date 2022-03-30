<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Tenant;

class Tenant
{
    public function __construct(
        public string $name,
        public string $identifier,
        public string $createdAt,
    )
    {
    }

    public static function fromArray(array $data): Tenant
    {
        return new Tenant(
            data_get($data, 'name'),
            data_get($data, 'identifier'),
            data_get($data, 'createdAt'),
        );
    }
}
