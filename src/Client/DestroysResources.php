<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 29.03.22
 */

namespace Rissc\Printformer\Client;

trait DestroysResources
{
    use UnwrapsResourceIdentifier;

    public function destroy(string|Resource $resource): bool
    {
        return $this
                ->delete($this->buildPath($this->getIdentifier($resource)))
                ->getStatusCode() === 204;
    }
}
