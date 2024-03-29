<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Client\VariableData;

use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use Rissc\Printformer\Client\Client as Base;
use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\File\File;
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Util\BuildsResourcePaths;
use Rissc\Printformer\Util\UnwrapsResourceIdentifier;

/**
 * @internal
 */
class Client extends Base implements VariableDataClient
{
    use UnwrapsResourceIdentifier;
    use BuildsResourcePaths;

    public function __construct(HTTPClient $http, string|Draft $draft)
    {
        parent::__construct($http, sprintf('%s/%s/variable-data', Draft::getPath(), static::unwrapResource($draft)));
    }

    public function list(int $page, int $perPage = 25): Paginator
    {
        $page = $page === 0 ? 1 : $page;
        $limit = $perPage;
        $offset = $perPage * ($page - 1);

        $response = $this->get($this->path . '?' . self::buildQuery(compact('limit', 'offset')));
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);
        $meta = $responseBody['_meta'];
        $amountOfRows = $meta['amountOfRows'];

        return new Paginator(
            $responseBody['data'],
            new PaginationMeta($page, (int)ceil($amountOfRows / $perPage), $perPage, $amountOfRows),
            $this
        );
    }

    public function create(\SplFileInfo|File|string $file, array $columnMapping): bool
    {
        if ($file instanceof \SplFileInfo) {
            return self::assertEmptyResponse(
                $this->http->request('POST', $this->path, [
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => file_get_contents($file->getRealPath()),
                            'filename' => $file->getFilename()
                        ],
                        [
                            'name' => 'columnMapping',
                            'contents' => json_encode($columnMapping)
                        ]
                    ],
                ]));
        }

        return self::assertEmptyResponse($this->post($this->path, [
            'file' => static::unwrapResource($file),
            'columnMapping' => $columnMapping
        ]));
    }

    public function update(array $data): bool
    {
        return self::assertEmptyResponse($this->put($this->path, compact('data')));
    }
}
