<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Feed;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Proxy extends Base implements FeedClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private FeedClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function store(array $data): Feed
    {
        return $this->wrap(fn(): Feed => $this->client->store($data));
    }

    public function show(string $identifier): Feed
    {
        return $this->wrap(fn(): Feed => $this->client->show($identifier));
    }

    public function update(string $identifier, array $data): Feed
    {
        return $this->wrap(fn(): Feed => $this->client->update($identifier, $data));
    }

    public function destroy(string $identifier): bool
    {
        return $this->wrap(fn(): bool => $this->client->destroy($identifier));
    }
}
