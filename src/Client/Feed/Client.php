<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Feed;

use Rissc\Printformer\Client\DestroysResources;
use Rissc\Printformer\Client\ResourceClient;

/**
 * @internal
 * @extends ResourceClient<Feed>
 */
class Client extends ResourceClient implements FeedClient
{
    use DestroysResources;

    protected static string $resource = Feed::class;

    public function create(array $data): Feed
    {
        return $this->createResource($data);
    }

    public function show(string|Feed $feed): Feed
    {
        return $this->showResource($feed);
    }

    public function update(string|Feed $feed, array $data): Feed
    {
        return $this->updateResource($feed, $data);
    }
}
