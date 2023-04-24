<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\File;

use GuzzleHttp\Utils;
use Psr\Http\Message\ResponseInterface;
use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<File>
 */
class Client extends ResourceClient implements FileClient
{
    protected static string $resource = File::class;

    public function create(\SplFileInfo $file): File
    {
        return self::resourceFromResponse($this->http->request('POST', $this->path, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => file_get_contents($file->getRealPath()),
                    'filename' => $file->getFilename()
                ]
            ],
        ]));
    }

    /**
     * @return File
     */
    protected static function resourceFromResponse(ResponseInterface $response): Resource
    {
        return File::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true));
    }
}
