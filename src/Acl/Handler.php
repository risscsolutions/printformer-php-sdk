<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Acl;

use Rissc\Printformer\Util\Util;

class Handler
{
    /** @return array{allowAction:bool, action:string, userIdentifier:string, entityType:string, entityIdentifier:string} */
    public function __invoke(\IteratorAggregate $request, \Closure $closure): array
    {
        $actions = iterator_to_array($request)['actions'] ?? [];
        foreach ($actions as &$action) {
            $action['allowAction'] = $closure(new Action(
                Util::get($action, 'action'),
                Util::get($action, 'userIdentifier'),
                Util::get($action, 'entityType'),
                Util::get($action, 'entityIdentifier'),
            ));
        }
        return $actions;
    }
}
