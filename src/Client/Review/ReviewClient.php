<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Client\Review;

use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\User\User;

interface ReviewClient
{
    /** @param array<string|User> $user */
    public function create(string|Draft $draft, array $user, string $closeCallbackURL, bool $remoteAcl = false): Review;

    public function deleteUser(string|Review $review, string|User $user): bool;

    public function addUser(string|Review $review, string|User $user): bool;

    public function closeReview(string|Review $review): bool;

    public function createReviewPDF(string|Review $review, string $callbackURL): bool;
}
