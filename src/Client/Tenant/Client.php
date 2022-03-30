<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Tenant;

use Rissc\Printformer\Client\Client as Base;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

class Client extends Base implements TenantClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'client');
    }

    public function show(): Tenant
    {
        return self::tenantFromResponse($this->get($this->resource));
    }

    protected static function tenantFromResponse(ResponseInterface $response): Tenant
    {
        return Tenant::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
