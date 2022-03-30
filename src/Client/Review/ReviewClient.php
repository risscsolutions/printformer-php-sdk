<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Client\Review;

interface ReviewClient
{
    public function create(string $draftId, array $user, string $closeCallbackURL, bool $remoteAcl = false): Review;

    public function deleteUser(string $review, string $userIdentifier): bool;

    public function addUser(string $review, string $userIdentifier): bool;

    public function closeReview(string $review): bool;

    public function createReviewPDF(string $review, string $callbackURL): bool;
}
