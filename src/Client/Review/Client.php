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
use Rissc\Printformer\Client\ResourceClient;
use Rissc\Printformer\Client\User\User;

/**
 * @internal
 */
class Client extends ResourceClient implements ReviewClient
{
    protected static string $resource = Review::class;

    public function create(string|Draft $draft, array $user, string $closeCallbackURL, bool $remoteAcl = false): Review
    {
        $draftId = $this->getIdentifier($draft);
        $user = array_map(fn(string|User $userOrIdentifier): string => $this->getIdentifier($userOrIdentifier), $user);

        return $this->createResource(compact('draftId', 'user', 'closeCallbackURL', 'remoteAcl'));
    }

    public function deleteUser(string|Review $review, string|User $user): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($this->getIdentifier($review), 'delete-user'), ['userIdentifier' => $this->getIdentifier($user)])
        );
    }

    public function addUser(string|Review $review, string|User $user): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($this->getIdentifier($review), 'add-user'), ['userIdentifier' => $this->getIdentifier($user)])
        );
    }

    public function closeReview(string|Review $review): bool
    {
        return self::assertEmptyResponse(
            $this->http->post($this->buildPath($this->getIdentifier($review), 'close-review'))
        );
    }

    public function createReviewPDF(string|Review $review, string $callbackURL): bool
    {
        return self::assertEmptyResponse(
            $this->post($this->buildPath($this->getIdentifier($review), 'create-review-pdf'), [
                'notifyCallbackURL' => $callbackURL
            ])
        );
    }
}
