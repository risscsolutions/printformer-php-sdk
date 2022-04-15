<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 12.04.22
 */

namespace Rissc\Printformer\Client\Derivative;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
*/
class Client extends ResourceClient implements DerivativeClient
{
    protected static string $resource = Derivative::class;

    public function __construct(HTTPClient $http, private Resource $owner)
    {
        parent::__construct($http);
    }

    public function list(int $page): Paginator
    {
        $page = $page === 0 ? 1 : $page;
        $response = $this->get(self::buildResourcePath($this->owner, $this->path) . '?' . self::buildQuery(compact('page')));
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);

        return new Paginator(
            array_map(static fn(array $derivative) => Derivative::fromArray($derivative), $responseBody['data']),
            PaginationMeta::fromArray($responseBody['meta']),
            $this,
        );
    }

    public function show(string|Derivative $derivative): Derivative
    {
        return $this->showResource($derivative);
    }
}
