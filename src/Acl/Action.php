<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Acl;

class Action
{
    public function __construct(
        public string $action,
        public string $userIdentifier,
        public string $entityType,
        public string $entityIdentifier
    )
    {
    }
}
