<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Client\VariableData;

use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;

/**
 * @internal
 */
class Proxy extends Base implements VariableDataClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private VariableDataClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function list(int $limit, int $offset = 0): array
    {
        return $this->wrap(fn(): array => $this->client->list($limit, $offset));
    }

    public function create(\SplFileInfo $file, array $columnMapping): bool
    {
        return $this->wrap(fn(): bool => $this->client->create($file, $columnMapping));
    }

    public function update(array $data): bool
    {
        return $this->wrap(fn(): bool => $this->client->update($data));
    }
}
