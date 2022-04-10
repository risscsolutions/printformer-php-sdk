<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\MasterTemplate;

use Rissc\Printformer\Client\Client as Base;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;

/**
 * @internal
 */
class Client extends Base implements MasterTemplateClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'template');
    }

    public function list(int $page): Paginator
    {
        $page = $page === 0 ? 1 : $page;
        $response = $this->get(sprintf('template?%s', http_build_query(array_filter(compact('page'), static fn(?string $value) => !empty($value)))));
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);

        return new Paginator(
            array_map(static fn(array $master) => MasterTemplate::fromArray($master), $responseBody['data']),
            PaginationMeta::fromArray($responseBody['meta']),
            $this,
        );
    }

    protected static function masterTemplateFromResponse(ResponseInterface $response): MasterTemplate
    {
        return MasterTemplate::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
