<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\File;

use Rissc\Printformer\Client\Client as Base;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class Client extends Base implements FileClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'file');
    }

    public function create(\SplFileInfo $file): File
    {
        return self::fileFromResponse($this->http->post($this->resource, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => file_get_contents($file->getRealPath()),
                    'filename' => $file->getFilename()
                ]
            ],
        ]));
    }

    protected static function fileFromResponse(ResponseInterface $response): File
    {
        return File::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
