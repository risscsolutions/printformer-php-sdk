<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client;

use GuzzleHttp\ClientInterface as HTTPClient;
use Psr\Http\Message\ResponseInterface;

abstract class Client
{
    public function __construct(protected HTTPClient $http, protected string $resource)
    {
    }

    protected function get(string $uri): ResponseInterface
    {
        return $this->http->get($uri);
    }

    protected function post(string $uri, array $data): ResponseInterface
    {
        return $this->http->post($uri, [
            'json' => $data
        ]);
    }

    protected function put(string $uri, array $data): ResponseInterface
    {
        return $this->http->put($uri, [
            'json' => $data
        ]);
    }

    protected function delete(string $uri): ResponseInterface
    {
        return $this->http->delete($uri);
    }

    protected function buildPath(string $identifier, ?string $action = null): string
    {
        return implode('/', array_filter([$this->resource, $identifier, $action], static fn(?string $value) => !empty($value)));
    }
}
