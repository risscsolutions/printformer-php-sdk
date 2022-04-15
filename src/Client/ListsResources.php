<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Client;

use GuzzleHttp\Utils;
use Psr\Http\Message\ResponseInterface;

trait ListsResources
{
    public function list(int $page, int $perPage = 25): Paginator
    {
        $queryParams = ['page' => $page === 0 ? 1 : $page, 'per_page' => $perPage];
        $response = $this->get($this->path . '?' . self::buildQuery($queryParams));

        return $this->paginatorFromResponse($response);
    }

    protected function paginatorFromResponse(ResponseInterface $response): Paginator
    {
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);
        return new Paginator(
            array_map(static fn(array $derivative) => static::$resource::fromArray($derivative), $responseBody['data']),
            PaginationMeta::fromArray($responseBody['meta']),
            $this,
        );
    }
}
