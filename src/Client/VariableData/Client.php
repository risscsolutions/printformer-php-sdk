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
use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\Client as Base;
use Symfony\Component\HttpFoundation\Response;

class Client extends Base implements VariableDataClient
{
    #[Pure] public function __construct(HTTPClient $http, string $draft)
    {
        parent::__construct($http, sprintf('draft/%s/variable-data', $draft));
    }

    public function list(int $limit, int $offset = 0): array
    {
        return Utils::jsonDecode(
            $this->get($this->resource . '?' . http_build_query(compact('limit', 'offset')))
                ->getBody()
                ->getContents()
        );
    }

    public function create(\SplFileInfo $file, array $columnMapping): bool
    {
        return $this->http->post($this->resource, [
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
            ])->getStatusCode() === Response::HTTP_NO_CONTENT;
    }

    public function update(array $data): bool
    {
        return $this->put($this->resource, compact('data'))->getStatusCode() === Response::HTTP_NO_CONTENT;
    }
}
