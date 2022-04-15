<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 28.03.22
 */

namespace Rissc\Printformer\Acl;

use Symfony\Component\HttpFoundation\ParameterBag;

class Handler
{
    /** @return array{allowAction:bool, action:string, userIdentifier:string, entityType:string, entityIdentifier:string} */
    public function __invoke(ParameterBag $request, \Closure $closure): array
    {
        $actions = $request->get('actions');
        foreach ($actions as &$action) {
            $action['allowAction'] = $closure(new Action(
                data_get($action, 'action'),
                data_get($action, 'userIdentifier'),
                data_get($action, 'entityType'),
                data_get($action, 'entityIdentifier'),
            ));
        }
        return $actions;
    }
}
