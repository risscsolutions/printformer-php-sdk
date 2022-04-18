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
use Rissc\Printformer\Client\Resource;
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Client\User\User;

/**
 * @internal
 * @extends ResourceClient<Draft>
 */
class Client extends ResourceClient implements DraftClient
{
    use DestroysResources;

    protected static string $resource = Draft::class;

    public function create(array $data): Draft
    {
        return $this->createResource(
            array_map(static fn(mixed $val): mixed => $val instanceof Resource ? $val->getIdentifier() : $val, $data)
        );
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
            $this->buildPath($draft, 'replicate'),
            $data
        ));
    }

    public function claim(string|User $user, array $drafts, bool $dryRun = false): array
    {
        return Utils::jsonDecode(
            $this
                ->post($this->buildPath('claim'), [
                    'user_identifier' => static::unwrapResource($user),
                    'drafts' => static::unwrapArray($drafts),
                    'dryRun' => $dryRun
                ])
                ->getBody()
                ->getContents(),
            true
        );
    }

    public function pageInfo(string|Draft $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo
    {
        $path = implode('/', [Draft::getPath(), static::unwrapResource($draft), $usage, 'page-info']);
        $url = $path . '?' . self::buildQuery(compact('row', 'unit'));
        return PageInfo::fromArray(Utils::jsonDecode($this->get($url)->getBody()->getContents(), true)['data']);
    }

    public function requestIdmlPackage(string|Draft $draft, string $callbackURL): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($draft, 'request-idml-package'), compact('callbackURL'))
        );
    }
}
