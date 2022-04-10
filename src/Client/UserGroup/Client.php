<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\UserGroup;

use Rissc\Printformer\Client\Client as Base;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class Client extends Base implements UserGroupClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'user-group');
    }

    public function create(): UserGroup
    {
        return self::userGroupFromResponse($this->http->post($this->resource));
    }

    public function show(string $identifier): UserGroup
    {
        return self::userGroupFromResponse($this->get($this->buildPath($identifier)));
    }

    private static function userGroupFromResponse(ResponseInterface $response): UserGroup
    {
        return UserGroup::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
