<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client\File;

use Rissc\Printformer\Client\BadRequestHandler;
use JetBrains\PhpStorm\Pure;

class Proxy extends \Rissc\Printformer\Client\Proxy implements FileClient
{
    #[Pure] public function __construct(BadRequestHandler $badRequestHandler, private FileClient $client)
    {
        parent::__construct($badRequestHandler);
    }

    public function create(\SplFileInfo $file): File
    {
        return $this->wrap(fn(): File => $this->client->create($file));
    }
}
