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
use Symfony\Component\HttpFoundation\Response;

final class BadRequestHandler
{
    public function responseToException(BadResponseException $exception): void
    {
        $response = $exception->getResponse();
        $responseBody = Utils::jsonDecode($response->getBody()->getContents(), true);

        throw match ($response->getStatusCode()) {
            Response::HTTP_UNPROCESSABLE_ENTITY => (new ValidationException($exception->getMessage(), $exception->getCode(), $exception))->setErrors($responseBody['errors'] ?? [$responseBody['message']]),
            Response::HTTP_FORBIDDEN => new FeatureNotEnabledException($responseBody['message'], $exception->getCode(), $exception),
            Response::HTTP_NOT_FOUND => new NotFoundException($responseBody['message'], $exception->getCode(), $exception),
            Response::HTTP_TOO_MANY_REQUESTS => new TooManyRequestsException($responseBody['message'], $exception->getCode(), $exception),
            Response::HTTP_BAD_GATEWAY, Response::HTTP_SERVICE_UNAVAILABLE => new MaintenanceException($exception->getMessage(), $exception->getCode(), $exception),
            Response::HTTP_INTERNAL_SERVER_ERROR => $exception,
            default => $exception,
        };
    }
}
