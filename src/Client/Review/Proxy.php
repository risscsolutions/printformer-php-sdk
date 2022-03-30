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

    #[ArrayShape(['draftId' => 'string', 'user' => 'array', 'closeCallbackURL' => 'string', 'remoteAcl' => 'bool'])]
    public function create(array $data): Review
    {
        return $this->wrap(fn(): Review => $this->client->create($data));
    }
}
