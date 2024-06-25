<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use GuzzleHttp\Utils;
use Psr\Http\Message\ResponseInterface;
use Rissc\Printformer\Client\ListsResources;
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<MasterTemplate>
 */
class Client extends ResourceClient implements MasterTemplateClient
{
    /** @use ListsResources<MasterTemplate> */
    use ListsResources {
        list as private _list;
    }

    protected static string $resource = MasterTemplate::class;

    /**
     * @param int $page
     * @param int $perPage
     * @return Paginator<MasterTemplate>
     */
    public function list(int $page, int $perPage = 25): Paginator
    {
        $queryParams = ['page' => $page === 0 ? 1 : $page, 'per_page' => $perPage];
        $response = $this->get($this->path . '?' . self::buildQuery($queryParams));

        return $this->resourcePaginatorFromResponse($response);
    }

    public function show(string|MasterTemplate $template): MasterTemplate
    {
        return $this->showResource($template);
    }

    /**
     * @param ResponseInterface $response
     * @return Paginator<array>
     */
    protected function arrayPaginatorFromResponse(ResponseInterface $response): Paginator
    {
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);
        return new Paginator(
            $responseBody['data'],
            PaginationMeta::fromArray($responseBody['meta']),
            $this,
        );
    }
}
