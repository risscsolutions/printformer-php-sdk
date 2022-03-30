<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 30.03.22
 */

namespace Rissc\Printformer\Client\VariableData;

interface VariableDataClient
{
    public function list(int $limit, int $offset = 0): array;

    public function create(\SplFileInfo $file, array $columnMapping): bool;

    public function update(array $data): bool;
}
