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

class Client extends Base implements MasterTemplateClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'template');
    }

    public function list(?int $page = null): array
    {
        $response = $this->get(sprintf('template?%s', http_build_query(array_filter(compact('page'), static fn(?string $value) => !empty($value)))));
        $masters = Utils::jsonDecode($response->getBody()->getContents(), true)['data'];

        return array_map(static fn(array $master) => MasterTemplate::fromArray($master), $masters);
    }

    protected static function masterTemplateFromResponse(ResponseInterface $response): MasterTemplate
    {
        return MasterTemplate::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
