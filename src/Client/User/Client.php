<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 26.03.22
 */

namespace Rissc\Printformer\Client\User;

use Rissc\Printformer\Client\Client as Base;
use Rissc\Printformer\Client\DestroysResources;
use Rissc\Printformer\Exceptions\SuccessFalseException;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class Client extends Base implements UserClient
{
    use DestroysResources;

    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'user');
    }

    #[ArrayShape(['email' => 'string', 'firstName' => 'string', 'lastName' => 'string', 'title' => 'string', 'salutation' => 'string', 'customAttributes' => 'array', 'locale' => 'string',])]
    public function create(array $data): User
    {
        return self::userFromResponse($this->post($this->resource, $data));
    }

    public function show(string $identifier): User
    {
        return self::userFromResponse($this->get($this->buildPath($identifier)));
    }

    #[ArrayShape(['email' => 'string', 'firstName' => 'string', 'lastName' => 'string', 'title' => 'string', 'salutation' => 'string', 'customAttributes' => 'array', 'locale' => 'string',])]
    public function update(string $identifier, array $data): User
    {
        return self::userFromResponse($this->put($this->buildPath($identifier), $data));
    }

    public function merge(string $targetUser, string $sourceUser): User
    {
        $mergeResponse = $this->post($this->buildPath($targetUser, 'merge'), ['source_user_identifier' => $sourceUser]);
        if (Utils::jsonDecode($mergeResponse->getBody()->getContents())['success'] === false) {
            throw new SuccessFalseException();
        }
        return $this->show($targetUser);
    }

    protected static function userFromResponse(ResponseInterface $response): User
    {
        return User::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
