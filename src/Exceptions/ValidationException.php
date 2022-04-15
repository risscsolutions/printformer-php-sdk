<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 27.03.22
 */

namespace Rissc\Printformer\Exceptions;

class ValidationException extends \LogicException
{
    /** @var array<string,string> */
    protected array $errors;

    /** @return array<string,string> */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /** @param array<string,string> $errors */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        $this->message = json_encode($errors, JSON_PRETTY_PRINT);

        return $this;
    }
}
