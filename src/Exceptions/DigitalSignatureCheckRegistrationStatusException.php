<?php

namespace Assetku\DigitalSignature\Exceptions;

class DigitalSignatureCheckRegistrationStatusException extends HasErrorsException
{
    /**
     * Display error message for failed check registration status data
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
     * Display error message for not found check registration status data
     *
     * @param  string  $message
     * @return static
     */
    public static function notFound(string $message)
    {
        return new static($message, 404);
    }

    /**
     * Display error message for unknown check registration status issue
     *
     * @return static
     */
    public static function unknown()
    {
        return new static('Unknown check registration status error', 500);
    }
}
