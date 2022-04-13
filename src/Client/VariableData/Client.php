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
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\UnwrapsResourceIdentifier;

/**
 * @internal
 */
class Client extends Base implements VariableDataClient
{
    use UnwrapsResourceIdentifier;

    public function __construct(HTTPClient $http, string|Draft $draft)
    {
        parent::__construct($http, sprintf('%s/%s/variable-data', Draft::getPath(), $this->getIdentifier($draft)));
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
            new PaginationMeta($page, ceil($amountOfRows / $perPage), $perPage, $amountOfRows),
            $this
        );
    }

    public function create(\SplFileInfo $file, array $columnMapping): bool
    {
        return self::assertEmptyResponse(
            $this->http->post($this->path, [
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

    public function update(array $data): bool
    {
        return self::assertEmptyResponse($this->put($this->path, compact('data')));
    }
}
