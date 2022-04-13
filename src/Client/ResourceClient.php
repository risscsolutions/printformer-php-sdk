<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use Psr\Http\Message\ResponseInterface;

abstract class ResourceClient extends Client
{
    use UnwrapsResourceIdentifier;

    protected static string $resource;

    public function __construct(HTTPClient $http)
    {
       parent::__construct($http, static::$resource::getPath());
    }

    protected function showResource(string|Resource $resource): Resource
    {
        return static::resourceFromResponse($this->get($this->buildPath($this->getIdentifier($resource))));
    }

    public function createResource(array $data): Resource
    {
        return static::resourceFromResponse($this->post($this->path, $data));
    }

    protected function updateResource(string|Resource $resource, array $data): Resource
    {
        return static::resourceFromResponse($this->put($this->buildPath($this->getIdentifier($resource)), $data));
    }

    protected static function resourceFromResponse(ResponseInterface $response): Resource
    {
        return static::$resource::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
