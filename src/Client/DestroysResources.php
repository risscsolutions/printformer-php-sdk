<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client;

use Rissc\Printformer\Util\UnwrapsResourceIdentifier;

trait DestroysResources
{
    use UnwrapsResourceIdentifier;

    public function destroy(string|Resource $resource): bool
    {
        return self::assertEmptyResponse($this->delete($this->buildPath(static::unwrapResource($resource))));
    }
}
