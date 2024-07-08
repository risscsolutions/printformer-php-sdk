<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 08.07.24
 */

namespace Rissc\Printformer\Client\WebHook;

use Rissc\Printformer\Exceptions\MaintenanceException;
use Rissc\Printformer\Exceptions\NotFoundException;
use Rissc\Printformer\Exceptions\TooManyRequestsException;
use Rissc\Printformer\Exceptions\ValidationException;

interface WebHookClient
{
    /**
     * @param array{
     *     event: string,
     *     url: string
     * } $data
     * @return WebHook
     * @throws MaintenanceException|TooManyRequestsException|NotFoundException|ValidationException
     */
    public function create(array $data): WebHook;

    public function show(string|WebHook $webHook): WebHook;

    public function destroy(string|WebHook $webHook): bool;
}
