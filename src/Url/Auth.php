<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Url;

use GuzzleHttp\Psr7\Uri;

abstract class Auth extends Base
{
    public function __toString(): string
    {
        return (new Uri($this->config->get('base_uri')))
            ->withPath('/auth')
            ->withQuery(self::buildQuery([
                'jwt' => (string)$this->tokenBuilder,
            ]));
    }
}
