<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Client\Review;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Rissc\Printformer\Client\User\User;

/**
 * @internal
 */
class Proxy extends Base implements ReviewClient
{
    #[Pure]
    public function __construct(BadRequestHandler $badRequestHandler, private ReviewClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(string|Draft $draft, array $user, string $closeCallbackURL, bool $remoteAcl = false): Review
    {
        return $this->wrap(fn(): Review => $this->client->create($draft, $user, $closeCallbackURL, $remoteAcl));
    }

    public function deleteUser(string|Review $review, string|User $user): bool
    {
        return $this->wrap(fn(): bool => $this->client->deleteUser($review, $user));
    }

    public function addUser(string|Review $review, string|User $user): bool
    {
        return $this->wrap(fn(): bool => $this->client->addUser($review, $user));
    }

    public function closeReview(string|Review $review): bool
    {
        return $this->wrap(fn(): bool => $this->client->closeReview($review));
    }

    public function createReviewPDF(string|Review $review, string $callbackURL): bool
    {
        return $this->wrap(fn(): bool => $this->client->createReviewPDF($review, $callbackURL));
    }
}
