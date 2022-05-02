<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Url;

use GuzzleHttp\Psr7\Uri;
use Rissc\Printformer\Client\Draft\Draft;

final class Editor extends Auth
{
    public function draft(string|Draft $draft, ?string $callback = null, ?string $callback_cancel = null, ?string $callback_halt = null): self
    {
        $callbacks = array_map('base64_encode', array_filter(compact('callback', 'callback_cancel', 'callback_halt'), static fn(?string $value) => !empty($value)));
        $this->tokenBuilder->redirect = (new Uri($this->config->get('base_uri')))
            ->withPath(sprintf('/editor/%s', static::unwrapResource($draft)))
            ->withQuery(self::buildQuery($callbacks));
        $this->tokenBuilder->withJTI = true;
        return $this;
    }
}
