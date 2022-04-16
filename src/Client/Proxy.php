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
use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;
use Rissc\Printformer\Exceptions\ValidationException;

abstract class Proxy
{
    public function __construct(protected BadRequestHandler $badRequestHandler)
    {
    }

    /**
     * @return mixed|never
     * @throws MaintenanceException|TooManyRequestsException|NotFoundException|ValidationException
     */
    protected function wrap(\Closure $closure): mixed
    {
        try {
            return $closure();
        } catch (BadResponseException $exception) {
            $this->badRequestHandler->responseToException($exception);
        }
    }
}
