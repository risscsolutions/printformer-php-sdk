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
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 */
class Client extends ResourceClient implements MasterTemplateClient
{
    protected static string $resource = MasterTemplate::class;

    public function list(int $page): Paginator
    {
        $page = $page === 0 ? 1 : $page;
        $response = $this->get(sprintf('%s?%s', MasterTemplate::getPath(), self::buildQuery(compact('page'))));
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);

        return new Paginator(
            array_map(static fn(array $master) => MasterTemplate::fromArray($master), $responseBody['data']),
            PaginationMeta::fromArray($responseBody['meta']),
            $this,
        );
    }
}
