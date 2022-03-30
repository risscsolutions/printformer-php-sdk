<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use Rissc\Printformer\Client\Client as Base;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

class Client extends Base implements ProcessingClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'pdf-processing');
    }

    #[ArrayShape(['draftIds' => 'array', 'stateChangedNotifyUrl' => 'string'])]
    public function create(array $data): Processing
    {
        return self::processingFromResponse(
            $this->post($this->resource, $data)
        );
    }

    public function show(string $identifier): Processing
    {
        return self::processingFromResponse($this->get($this->buildPath($identifier)));
    }

    protected static function processingFromResponse(ResponseInterface $response): Processing
    {
        return Processing::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true));
    }
}
