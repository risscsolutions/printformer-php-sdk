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

class Review extends Auth
{
    public function review(string $review): self
    {
        $this->tokenBuilder->redirect = (new Uri($this->config->get('base_uri')))
            ->withPath(sprintf('/review/%s', $review));
        $this->tokenBuilder->withJTI = true;
        return $this;
    }
}
