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
     * Display error message for internal server error registration status data
     *
     * @param  string  $message
     * @return static
     */
    public static function internalServerError(string $message)
    {
        return new static($message, 500);
    }

    /**
     * Display error message for service unavailable registration status data
     *
     * @param  string  $message
     * @return static
     */
    public static function serviceUnavailable(string $message)
    {
        return new static($message, 503);
    }

    /**
     * Display error message for unknown registration issue
     *
     * @return static
     */
    public static function unknown()
    {
        return new static('Unknown registration error', 600);
    }
}
