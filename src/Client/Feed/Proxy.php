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

    public function create(array $data): Feed
    {
        return $this->wrap(fn(): Feed => $this->client->create($data));
    }

    public function show(string|Feed $feed): Feed
    {
        return $this->wrap(fn(): Feed => $this->client->show($feed));
    }

    public function update(string|Feed $feed, array $data): Feed
    {
        return $this->wrap(fn(): Feed => $this->client->update($feed, $data));
    }

    public function destroy(string|Feed $feed): bool
    {
        return $this->wrap(fn(): bool => $this->client->destroy($feed));
    }
}
