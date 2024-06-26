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
use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Util\BuildsResourcePaths;

/**
 * @internal
 * @extends ResourceClient<Derivative>
 */
class Client extends ResourceClient implements DerivativeClient
{
    /** @use ListsResources<Derivative> */
    use ListsResources {
        list as private _list;
    }

    use BuildsResourcePaths;

    protected static string $resource = Derivative::class;

    public function __construct(HTTPClient $http, private Resource $owner)
    {
        parent::__construct($http);
    }

    public function list(int $page, int $perPage = 25): Paginator
    {
        $queryParams = ['page' => $page === 0 ? 1 : $page, 'per_page' => $perPage];
        $response = $this->get(self::buildResourcePath($this->owner, $this->path) . '?' . self::buildQuery($queryParams));

        return $this->resourcePaginatorFromResponse($response);
    }

    public function show(string|Derivative $derivative): Derivative
    {
        return $this->showResource($derivative);
    }
}
