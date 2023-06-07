<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Client\VariableData;

use Rissc\Printformer\Client\File\File;
use Rissc\Printformer\Client\ProvidesListing;
use Rissc\Printformer\Exceptions\FeatureNotEnabledException;
use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;
use Rissc\Printformer\Exceptions\ValidationException;

/**
 * @extends ProvidesListing<array<int, array<string, string>>>
 */
interface VariableDataClient extends ProvidesListing
{
    /**
     * @param \SplFileInfo|File|string $file $file Either a csv or xls file
     * @param Array<int|string, int> $columnMapping Column name to column index mapping
     * @return bool
     * @throws MaintenanceException|TooManyRequestsException|NotFoundException|FeatureNotEnabledException|ValidationException
     * @api
     */
    public function create(\SplFileInfo|File|string $file, array $columnMapping): bool;

    /** @param array<int, array<string, string>> $data */
    public function update(array $data): bool;
}
