<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\Feed;

interface FeedClient
{
    public function store(array $data): Feed;

    public function show(string $identifier): Feed;

    public function update(string $identifier, array $data): Feed;

    public function destroy(string $identifier): bool;
}
