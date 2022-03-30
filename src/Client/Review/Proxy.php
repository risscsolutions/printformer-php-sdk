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
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Proxy extends Base implements ReviewClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private Client $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(string $draftId, array $user, string $closeCallbackURL, bool $remoteAcl = false): Review
    {
        return $this->wrap(fn(): Review => $this->client->create($draftId, $user, $closeCallbackURL, $remoteAcl));
    }

    public function deleteUser(string $review, string $userIdentifier): bool
    {
        return $this->wrap(fn(): bool => $this->client->deleteUser($review, $userIdentifier));
    }

    public function addUser(string $review, string $userIdentifier): bool
    {
        return $this->wrap(fn(): bool => $this->client->addUser($review, $userIdentifier));
    }

    public function closeReview(string $review): bool
    {
        return $this->wrap(fn(): bool => $this->client->closeReview($review));
    }

    public function createReviewPDF(string $review, string $callbackURL): bool
    {
        return $this->wrap(fn(): bool => $this->client->createReviewPDF($review, $callbackURL));
    }
}
