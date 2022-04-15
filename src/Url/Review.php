<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Url;

use GuzzleHttp\Psr7\Uri;
use Rissc\Printformer\Client\Review\Review as ReviewResource;

final class Review extends Auth
{
    public function review(string|ReviewResource $review): self
    {
        $this->tokenBuilder->redirect = (new Uri($this->config->get('base_uri')))
            ->withPath(sprintf('/%s/%s', ReviewResource::getPath(), static::unwrapResource($review)));
        $this->tokenBuilder->withJTI = true;
        return $this;
    }
}
