<?php

namespace Assetku\DigitalSignature\Exceptions;

class DigitalSignatureCheckDocumentStatusException extends HasErrorsException
{
    /**
     * Display error message for not found check document status data
     *
     * @param  string  $message
     * @return static
     */
    public static function notFound(string $message)
    {
        return new static($message, 404);
    }

    /**
     * Display error message for internal server error check document status status data
     *
     * @param  string  $message
     * @return static
     */
    public static function internalServerError(string $message)
    {
        return new static($message, 500);
    }

    /**
     * Display error message for service unavailable check document status status data
     *
     * @param  string  $message
     * @return static
     */
    public static function serviceUnavailable(string $message)
    {
        return new static($message, 503);
    }

    /**
     * Display error message for unknown check document status issue
     *
     * @return static
     */
    public static function unknown()
    {
        return new static('Unknown check document status error', 600);
    }
}
