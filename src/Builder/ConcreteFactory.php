<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Builder;

use Rissc\Printformer\Printformer;

class Factory
{
    public function __construct(private Printformer $printformer)
    {
    }

    public function draft(): DraftBuilder
    {
        return new DraftBuilder($this->printformer->clientFactory()->draft());
    }
}
