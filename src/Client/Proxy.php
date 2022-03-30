<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client;

use GuzzleHttp\Exception\BadResponseException;

abstract class Proxy
{
    public function __construct(protected BadRequestHandler $badRequestHandler)
    {
    }

    protected function wrap(\Closure $closure)
    {
        try {
            return $closure();
        } catch (BadResponseException $exception) {
            $this->badRequestHandler->responseToException($exception);
        }
    }
}
