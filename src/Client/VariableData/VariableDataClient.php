<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Client\VariableData;

use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ProvidesListing;
use Rissc\Printformer\Exceptions\FeatureNotEnabledException;
use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;
use Rissc\Printformer\Exceptions\ValidationException;

interface VariableDataClient extends ProvidesListing
{
    /**
     * @inheritDoc
     * @return Paginator<array>
     */
    public function list(int $page): Paginator;

    /**
     * @param \SplFileInfo $file Either a csv or xls file
     * @param Array<int|string, int> $columnMapping Column name to column index mapping
     * @return bool
     * @throws MaintenanceException|TooManyRequestsException|NotFoundException|FeatureNotEnabledException|ValidationException
     * @api
     */
    public function create(\SplFileInfo $file, array $columnMapping): bool;

    public function update(array $data): bool;
}
