<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use phpDocumentor\Reflection\Types\Scalar;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\User\User;

/**
 * @internal
 */
class Proxy extends Base implements DraftClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private DraftClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(array $data): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->create($data));
    }

    public function destroy(string|Draft $draft): bool
    {
        return $this->wrap(fn(): bool => $this->client->destroy($draft));
    }

    public function show(string|Draft $draft): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->show($draft));
    }

    public function update(string|Draft $draft, array $data): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->update($draft, $data));
    }

    public function replicate(string|Draft $draft, array $data): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->replicate($draft, $data));
    }

    public function claim(string|User $user, array $drafts, bool $dryRun = false): array
    {
        return $this->wrap(fn(): array => $this->client->claim($user, $drafts, $dryRun));
    }

    public function pageInfo(string|Draft $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo
    {
        return $this->wrap(fn(): PageInfo => $this->client->pageInfo($draft, $usage, $row, $unit));
    }

    public function requestIdmlPackage(string|Draft $draft, string $callbackURL): bool
    {
        return $this->wrap(fn(): bool => $this->client->requestIdmlPackage($draft, $callbackURL));
    }
}
