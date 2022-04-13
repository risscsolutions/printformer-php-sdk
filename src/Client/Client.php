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
use Symfony\Component\HttpFoundation\Response;

abstract class Client
{
    use BuildsQueryStrings;

    public function __construct(protected HTTPClient $http, protected string $path)
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
        return implode('/', array_filter([$this->path, $identifier, $action], static fn(?string $value) => !empty($value)));
    }

    protected function buildPathWithQuery(string $identifier, ?string $action = null, array $params = []): string
    {
        return sprintf('%s?%s', $this->buildPath($identifier, $action), self::buildQuery($params));
    }

    protected static function assertEmptyResponse(ResponseInterface $response): bool
    {
        return $response->getStatusCode() === Response::HTTP_NO_CONTENT;
    }
}
