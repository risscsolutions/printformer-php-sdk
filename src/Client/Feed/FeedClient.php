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
    public function create(array $data): Feed;

    public function show(string|Feed $feed): Feed;

    public function update(string|Feed $feed, array $data): Feed;

    public function destroy(string|Feed $feed): bool;
}
