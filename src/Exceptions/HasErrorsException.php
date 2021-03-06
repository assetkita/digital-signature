<?php

namespace Assetku\DigitalSignature\Exceptions;

use Exception;
use Throwable;

class HasErrorsException extends Exception
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * HasErrorsException constructor.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     * @param  array  $errors
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, array $errors = [])
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Format the privy failed errors to be consistent
     *
     * @param  array  $errors
     * @return array
     */
    protected static function formatPrivyFailedErrors(array $errors)
    {
        return collect($errors)->mapWithKeys(function ($error) {
            return [
                $error->field => $error->messages
            ];
        })->toArray();
    }
}
