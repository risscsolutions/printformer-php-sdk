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
    protected array $errors;

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;

        $this->message = json_encode($errors, JSON_PRETTY_PRINT);
    }
}
