<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use Rissc\Printformer\Client\Client as Base;
use Rissc\Printformer\Client\DestroysResources;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

class Client extends Base implements DraftClient
{
    use DestroysResources;

    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'draft');
    }

    public function create(array $data): Draft
    {
        return self::draftFromResponse($this->post($this->resource, $data));
    }

    public function show(string $identifier): Draft
    {
        return self::draftFromResponse($this->get($this->buildPath($identifier)));
    }

    public function update(string $identifier, array $data): Draft
    {
        return self::draftFromResponse($this->put($this->buildPath($identifier), $data));
    }

    public function replicate(string $identifier, array $data): Draft
    {
        return self::draftFromResponse($this->post($this->buildPath($identifier, 'replicate'), $data));
    }

    public function claim(string $user, array $identifiers, bool $dryRun = false): array
    {
        return Utils::jsonDecode(
            $this
                ->post('draft/claim', [
                    'user_identifier' => $user,
                    'drafts' => $identifiers,
                    'dryRun' => $dryRun
                ])
                ->getBody()
                ->getContents()
        );
    }

    public function pageInfo(string $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo
    {
        return PageInfo::fromArray(
            Utils::jsonDecode($this->get(sprintf('%s/%s/%s/page-info?%s', $this->resource, $draft, $usage, http_build_query(array_filter(compact('row', 'unit'), static fn(?string $value) => !empty($value))))
            )->getBody()->getContents(), true)['data']
        );
    }

    public function requestIdmlPackage(string $draft, string $callbackURL): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($draft, 'request-idml-package'), compact('callbackURL'))
        );
    }

    protected static function draftFromResponse(ResponseInterface $response): Draft
    {
        return Draft::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
