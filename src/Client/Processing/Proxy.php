<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Client\Processing;

use Rissc\Printformer\Client\BadRequestHandler;
use Rissc\Printformer\Client\Proxy as Base;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Proxy extends Base implements ProcessingClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private Client $client)
    {
        parent::__construct($badRequestHandler);
    }

    #[ArrayShape(['draftIds' => 'array', 'stateChangedNotifyUrl' => 'string'])] public function create(array $data): Processing
    {
        return $this->wrap(fn(): Processing => $this->client->create($data));
    }

    public function show(string $identifier): Processing
    {
        return $this->wrap(fn(): Processing => $this->client->show($identifier));
    }
}
