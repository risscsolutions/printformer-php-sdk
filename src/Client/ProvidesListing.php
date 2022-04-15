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
     * @param int $page starts at 1
     * @param int $perPage
     * @return Paginator<T>
     * @throws MaintenanceException
     * @throws TooManyRequestsException
     * @api
     */
    public function list(int $page, int $perPage = 25): Paginator;
}
