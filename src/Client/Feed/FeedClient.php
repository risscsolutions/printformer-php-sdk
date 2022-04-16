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
    /** @param array{name: string, mappingIdentifier: string, mediaProvider: string, type: string, shouldReplicate:bool, config:array, file:string, url:string} $data */
    public function create(array $data): Feed;

    public function show(string|Feed $feed): Feed;

    /** @param array{name: string, mappingIdentifier: string, mediaProvider: string, type: string, shouldReplicate:bool, config:array, file:string, url:string} $data */
    public function update(string|Feed $feed, array $data): Feed;

    public function destroy(string|Feed $feed): bool;
}
