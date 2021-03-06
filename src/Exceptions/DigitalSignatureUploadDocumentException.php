<?php

namespace Assetku\DigitalSignature\Exceptions;

class DigitalSignatureUploadDocumentException extends HasErrorsException
{
    /**
     * Display error message for failed upload document data
     *
     * @param  string  $message
     * @param  array  $errors
     * @return static
     */
    public static function failed(string $message, array $errors)
    {
        if (config('digital-signature.default') === 'privy') {
            $errors = static::formatPrivyFailedErrors($errors);
        }

        return new static($message, 422, null, $errors);
    }

    /**
     * Display error message for internal server error upload document status data
     *
     * @param  string  $message
     * @return static
     */
    public static function internalServerError(string $message)
    {
        return new static($message . ' from ' . config('digital-signature.default'), 500);
    }

    /**
     * Display error message for service unavailable upload document status data
     *
     * @param  string  $message
     * @return static
     */
    public static function serviceUnavailable(string $message)
    {
        return new static($message . ' from ' . config('digital-signature.default'), 503);
    }

    /**
     * Display error message for unknown upload document issue
     *
     * @return static
     */
    public static function unknown()
    {
        return new static('Unknown upload document error from ' . config('digital-signature.default'), 500);
    }
}
