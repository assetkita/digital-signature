<?php

namespace Assetku\DigitalSignature\Exceptions;

class DigitalSignatureValidatorException extends HasErrorsException
{
    /**
     * Display error message for failed passing rules
     *
     * @param  string  $message
     * @param  array  $errors
     * @return static
     */
    public static function failed(string $message, array $errors)
    {
        return new static($message, 422, null, $errors);
    }
}
