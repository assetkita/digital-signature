<?php

namespace Assetku\DigitalSignature\Exceptions;

use Exception;

class DigitalSignatureDriverException extends Exception
{
    /**
     * Display error message for unknown driver
     *
     * @return static
     */
    public static function unknownDriver()
    {
        return new static('Unknown digital signature driver, available: privy');
    }
}
