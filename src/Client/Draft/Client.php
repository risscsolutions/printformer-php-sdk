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
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class Client extends Base implements DraftClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'draft');
    }

    public function create(array $data): Draft
    {
        return self::draftFromResponse($this->post($this->resource, $data));
    }

    public function show(string|Draft $draft): Draft
    {
        return self::draftFromResponse($this->get($this->buildPath($this->getIdentifier($draft))));
    }

    public function update(string|Draft $draft, array $data): Draft
    {
        return self::draftFromResponse($this->put($this->buildPath($this->getIdentifier($draft)), $data));
    }

    public function replicate(string|Draft $draft, array $data): Draft
    {
        return self::draftFromResponse($this->post($this->buildPath(
            $this->getIdentifier($draft), 'replicate'), $data));
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

    public function pageInfo(string|Draft $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo
    {
        return PageInfo::fromArray(
            Utils::jsonDecode($this->get(sprintf('%s/%s/%s/page-info?%s', $this->resource, $this->getIdentifier($draft), $usage, http_build_query(array_filter(compact('row', 'unit'), static fn(?string $value) => !empty($value))))
            )->getBody()->getContents(), true)['data']
        );
    }

    public function requestIdmlPackage(string|Draft $draft, string $callbackURL): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($this->getIdentifier($draft), 'request-idml-package'), compact('callbackURL'))
        );
    }

    public function destroy(string|Draft $draft): bool
    {
        return $this
                ->delete($this->buildPath($this->getIdentifier($draft)))
                ->getStatusCode() === 204;
    }

    protected static function draftFromResponse(ResponseInterface $response): Draft
    {
        return Draft::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }

    private function getIdentifier(string|Draft $draft): string
    {
        return is_string($draft) ? $draft : $draft->draftHash;
    }
}
