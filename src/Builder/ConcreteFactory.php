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

/**
 * @internal
 */
class ConcreteFactory implements Factory
{
    public function __construct(private Printformer $printformer)
    {
    }

    public function draft(): DraftBuilder
    {
        return new DraftBuilder($this->printformer->clientFactory()->draft());
    }

    public function feed(): FeedBuilder
    {
        return new FeedBuilder($this->printformer->clientFactory()->feed());
    }
}
