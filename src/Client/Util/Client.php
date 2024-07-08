<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 06.07.24
 */

namespace Rissc\Printformer\Client\Util;


use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;

class Client extends \Rissc\Printformer\Client\Client implements UtilClient
{
    public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'util');
    }

    public function reAssemble(array $drafts, string $callbackURL): string
    {
        $response = $this->post('/pdf/re-assemble', compact('drafts', 'callbackURL'));
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);

        return $responseBody->identifier;
    }
}
