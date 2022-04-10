<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Feed;

use Rissc\Printformer\Client\Client as Base;
use Rissc\Printformer\Client\DestroysResources;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
/**
 * @internal
 */
class Client extends Base implements FeedClient
{
    use DestroysResources;

    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'product-feed');
    }

    public function store(array $data): Feed
    {
        return self::feedFromResponse($this->post($this->resource, $data));
    }

    public function show(string $identifier): Feed
    {
        return self::feedFromResponse($this->get($this->buildPath($identifier)));
    }

    public function update(string $identifier, array $data): Feed
    {
        return self::feedFromResponse($this->put($this->buildPath($identifier), $data));
    }

    protected static function feedFromResponse(ResponseInterface $response): Feed
    {
        return Feed::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
