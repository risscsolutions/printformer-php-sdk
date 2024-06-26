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
use Rissc\Printformer\Util\BuildsQueryStrings;

abstract class Client
{
    use BuildsQueryStrings;

    public function __construct(protected HTTPClient $http, protected string $path)
    {
    }

    protected function get(string $uri): ResponseInterface
    {
        return $this->http->request('GET', $uri);
    }

    /** @param array<mixed> $data */
    protected function post(string $uri, array $data): ResponseInterface
    {
        return $this->http->request('POST', $uri, [
            'json' => $data
        ]);
    }

    /** @param array<mixed> $data */
    protected function put(string $uri, array $data): ResponseInterface
    {
        return $this->http->request('PUT', $uri, [
            'json' => $data
        ]);
    }

    protected function delete(string $uri): ResponseInterface
    {
        return $this->http->request('DELETE', $uri);
    }

    protected static function assertEmptyResponse(ResponseInterface $response): bool
    {
        return $response->getStatusCode() === 204;
    }
}
