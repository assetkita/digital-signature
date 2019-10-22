<?php

namespace Assetku\DigitalSignature\Facades;

use Illuminate\Support\Facades\Facade;

class DigitalSignatureFacade extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'assetkita.digital_signature';
    }
}
