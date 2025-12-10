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
    /** @var array<string, null|string> */
    protected array $callbacks = [];
    protected null|string|Draft $draft = null;
    protected ?string $step = null;
    protected ?string $locale = null;

    public function draft(string|Draft $draft, ?string $callback = null, ?string $callback_cancel = null, ?string $callback_halt = null): self
    {
        $this->draft = $draft;
        if (!is_null($callback)) $this->callbacks = compact('callback', 'callback_cancel', 'callback_halt');
        return $this;
    }

    public function callback(?string $callback): self
    {
        $this->callbacks['callback'] = $callback;
        return $this;
    }

    public function callbackCancel(?string $callback): self
    {
        $this->callbacks['callback_cancel'] = $callback;
        return $this;
    }

    public function callbackHalt(?string $callback): self
    {
        $this->callbacks['callback_halt'] = $callback;
        return $this;
    }

    public function step(string $step): self
    {
        $this->step = $step;
        return $this;
    }

    public function locale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    public function __toString(): string
    {
        $path = $this->step
            ? sprintf('/editor/%s/%s', self::unwrapResource($this->draft), $this->step)
            : sprintf('/editor/%s', self::unwrapResource($this->draft));

        $params = array_map(
                'base64_encode',
                array_filter($this->callbacks, static fn (?string $value) => !empty($value))
            );

        if ($this->locale !== null && $this->locale !== '') {
            $params['locale'] = $this->locale;
        }

        $query = self::buildQuery($params);

        $this->tokenBuilder->redirect = (new Uri($this->config['base_uri']))
            ->withPath($path)
            ->withQuery($query);
        $this->tokenBuilder->withJTI = true;

        return parent::__toString();
    }
}
