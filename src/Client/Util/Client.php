<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 06.07.24
 */

namespace Rissc\Printformer\Client\Util;

use GuzzleHttp\ClientInterface as HTTPClient;
use Rissc\Printformer\Client\File\File;
use Rissc\Printformer\Util\UnwrapsResourceIdentifier;

class Client extends \Rissc\Printformer\Client\Client implements UtilClient
{
    use UnwrapsResourceIdentifier;

    public function __construct(HTTPClient $http)
    {
        parent::__construct($http, 'util');
    }

    public function reAssemble(array $drafts, string $callbackURL): void
    {
        $this->post($this->path . '/pdf/re-assemble', compact('drafts', 'callbackURL'));
    }

    public function optimize(string|File $file, string $callbackURL, ?int $dpi = null): void
    {
        $this->post($this->path . '/pdf/optimize', [
            'file' => static::unwrapResource($file),
            'callbackURL' => $callbackURL,
            'dpi' => $dpi,
        ]);
    }
}
