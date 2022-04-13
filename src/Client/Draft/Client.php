<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use GuzzleHttp\Utils;
use Rissc\Printformer\Client\DestroysResources;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 */
class Client extends ResourceClient implements DraftClient
{
    use DestroysResources;

    protected static string $resource = Draft::class;

    public function create(array $data): Draft
    {
        return $this->createResource($data);
    }

    public function show(string|Draft $draft): Draft
    {
        return $this->showResource($draft);
    }

    public function update(string|Draft $draft, array $data): Draft
    {
        return $this->updateResource($draft, $data);
    }

    public function replicate(string|Draft $draft, array $data): Draft
    {
        return self::resourceFromResponse($this->post(
            $this->buildPath($this->getIdentifier($draft), 'replicate'),
            $data
        ));
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
        $url = sprintf('%s/%s/%s/page-info?%s', Draft::getPath(), $this->getIdentifier($draft), $usage, http_build_query(array_filter(compact('row', 'unit'), static fn(?string $value) => !empty($value))));
        return PageInfo::fromArray(Utils::jsonDecode($this->get($url)->getBody()->getContents(), true)['data']);
    }

    public function requestIdmlPackage(string|Draft $draft, string $callbackURL): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($this->getIdentifier($draft), 'request-idml-package'), compact('callbackURL'))
        );
    }
}
