<?php

namespace Assetku\DigitalSignature\Exceptions;

class DigitalSignatureRegistrationException extends HasErrorsException
{
    /**
     * Display error message for failed registration data
     *
     * @param  string  $message
     * @param  array  $errors
     * @return static
     */
    public static function failed(string $message, array $errors)
    {
        return new static($message, 422, null, $errors);
    }

    /**
     * Display error message for unknown registration issue
     *
     * @return static
     */
    public static function unknown()
    {
        return new static('Unknown registration error', 500);
    }
}
