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
use Rissc\Printformer\Exceptions\ValidationException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Utils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class BadRequestHandler
{
    public function responseToException(BadResponseException $exception): void
    {
        $response = $exception->getResponse();
        $responseBody = Utils::jsonDecode($exception->getBody()->getContents(), true);

        switch ($response->getStatusCode()) {
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                $e = new ValidationException();
                $e->setErrors($responseBody['errors'] ?? [$responseBody['message']]);
                throw $e;
            case Response::HTTP_FORBIDDEN:
                throw new FeatureNotEnabledException($responseBody['message']);
            case Response::HTTP_NOT_FOUND:
                throw new NotFoundException($responseBody['message']);
            case Response::HTTP_TOO_MANY_REQUESTS:
                throw new TooManyRequestsHttpException(
                    $response->getHeaderLine('Retry-After'),
                    $responseBody['message']
                );
            case Response::HTTP_BAD_GATEWAY:
            case Response::HTTP_SERVICE_UNAVAILABLE:
                throw new MaintenanceException();
            case Response::HTTP_INTERNAL_SERVER_ERROR:
            default:
                throw $exception;
        }
    }
}
