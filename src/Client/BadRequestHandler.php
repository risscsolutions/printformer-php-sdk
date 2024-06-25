<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client;

use Rissc\Printformer\Exceptions\FeatureNotEnabledException;
use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;
use Rissc\Printformer\Exceptions\ValidationException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Utils;

final class BadRequestHandler
{
    /** @return never-returns */
    public function responseToException(BadResponseException $exception): void
    {
        $response = $exception->getResponse();
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);

        throw match ($response->getStatusCode()) {
            422 => (new ValidationException($exception->getMessage(), $exception->getCode(), $exception))->setErrors($responseBody['errors'] ?? [$responseBody['message']]),
            403 => new FeatureNotEnabledException($responseBody['message'], $exception->getCode(), $exception),
            404 => new NotFoundException($responseBody['message'], $exception->getCode(), $exception),
            429 => new TooManyRequestsException($responseBody['message'], $exception->getCode(), $exception),
            502, 503 => new MaintenanceException($exception->getMessage(), $exception->getCode(), $exception),
            500 => $exception,
            default => $exception,
        };
    }
}
