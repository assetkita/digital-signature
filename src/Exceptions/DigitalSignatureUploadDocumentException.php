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
        return new static($message, 422, null, $errors);
    }

    /**
     * Display error message for unknown upload document issue
     *
     * @return static
     */
    public static function unknown()
    {
        return new static('Unknown registration error', 500);
    }
}
