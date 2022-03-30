<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Client\Review;

use JetBrains\PhpStorm\ArrayShape;

interface ReviewClient
{
    #[ArrayShape(['draftId' => 'string', 'user' => 'array', 'closeCallbackURL' => 'string', 'remoteAcl' => 'bool'])]
    public function create(array $data): Review;

    public function deleteUser(string $review, string $userIdentifier): bool;

    public function addUser(string $review, string $userIdentifier): bool;

    public function closeReview(string $review): bool;

    public function createReviewPDF(string $review, string $callbackURL): bool;
}
