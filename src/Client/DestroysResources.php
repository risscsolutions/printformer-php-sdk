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
    public function destroy(string $identifier): bool
    {
        return $this
                ->delete($this->buildPath($identifier))
                ->getStatusCode() === 204;
    }
}
