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
use Rissc\Printformer\Util\BuildsResourcePaths;
use Rissc\Printformer\Util\UnwrapsResourceIdentifier;

/**
 * @template T of Resource
 */
abstract class ResourceClient extends Client
{
    use UnwrapsResourceIdentifier;
    use BuildsResourcePaths;

    /** @var class-string<Resource> */
    protected static string $resource;

    public function __construct(HTTPClient $http)
    {
        parent::__construct($http, static::$resource::getPath());
    }

    /**
     * @return T
     */
    protected function showResource(string|Resource $resource): Resource
    {
        return static::resourceFromResponse($this->get($this->buildPath($resource)));
    }

    /**
     * @return T
     */
    public function createResource(array $data): Resource
    {
        return static::resourceFromResponse($this->post($this->path, $data));
    }

    /**
     * @return T
     */
    protected function updateResource(string|Resource $resource, array $data): Resource
    {
        return static::resourceFromResponse($this->put($this->buildPath($resource), $data));
    }

    protected function buildPath(string|Resource $resource, ?string $action = null): string
    {
        return implode('/', array_filter([$this->path, static::unwrapResource($resource), $action], static fn(?string $value) => !empty($value)));
    }

    /**
     * @return T
     */
    protected static function resourceFromResponse(ResponseInterface $response): Resource
    {
        return static::$resource::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
