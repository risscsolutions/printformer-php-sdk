<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Draft;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use Rissc\Printformer\Exceptions\ValidationException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use function dd;

class Proxy extends Base implements DraftClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private Client $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(array $data): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->create($data));
    }

    public function destroy(string $identifier): bool
    {
        return $this->wrap(fn(): bool => $this->client->destroy($identifier));
    }

    public function show(string $identifier): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->show($identifier));
    }

    public function update(string $identifier, array $data): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->update($identifier, $data));
    }

    #[ArrayShape([
        'pagePlanner' => [
            'projectCode' => 'string',
            'projectName' => 'string',
        ],
        'apiDefaultValues' => 'array',
        'customAttributes' => 'array',
        'draftParameter' => 'array',

    ])] public function replicate(string $identifier, array $data): Draft
    {
        return $this->wrap(fn(): Draft => $this->client->replicate($identifier, $data));
    }

    public function claim(string $user, array $identifiers, bool $dryRun = false): array
    {
        return $this->wrap(fn(): array => $this->client->claim($user, $identifiers, $dryRun));
    }

    public function pageInfo(string $draft, string $usage, ?int $row = null, ?string $unit = null): PageInfo
    {
        return $this->wrap(fn(): PageInfo => $this->client->pageInfo($draft, $usage, $row, $unit));
    }

    public function requestIdmlPackage(string $draft, string $callbackURL): bool
    {
        return $this->wrap(fn(): bool => $this->client->requestIdmlPackage($draft, $callbackURL));
    }
}
