<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Client\Review;

use Rissc\Printformer\Client\Client as Base;
use GuzzleHttp\ClientInterface as HTTPClient;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
class Client extends Base implements ReviewClient
{
    #[Pure] public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'review');
    }

    public function create(string $draftId, array $user, string $closeCallbackURL, bool $remoteAcl = false): Review
    {
        return self::reviewFromResponse($this->post($this->resource, compact('draftId', 'user', 'closeCallbackURL', 'remoteAcl')));
    }

    public function deleteUser(string $review, string $userIdentifier): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($review, 'delete-user'), compact('userIdentifier'))
        );
    }

    public function addUser(string $review, string $userIdentifier): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($review, 'add-user'), compact('userIdentifier'))
        );
    }

    public function closeReview(string $review): bool
    {
        return self::assertEmptyResponse(
            $this->http->post($this->buildPath($review, 'close-review'))
        );
    }

    public function createReviewPDF(string $review, string $callbackURL): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($review, 'create-review-pdf'), [
                'notifyCallbackURL' => $callbackURL
            ])
        );
    }

    protected static function reviewFromResponse(ResponseInterface $response): Review
    {
        return Review::fromArray(Utils::jsonDecode($response->getBody()->getContents(), true)['data']);
    }
}
