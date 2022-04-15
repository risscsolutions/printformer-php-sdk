<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Client;

use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;

/**
 * @template T
 */
interface ProvidesListing
{
    /**
     * @api
     * @param int $page starts at 1
     * @throws MaintenanceException|TooManyRequestsException
     * @return Paginator<int, T>
     */
    public function list(int $page): Paginator;
}
