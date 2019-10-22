<?php

namespace Assetku\DigitalSignature\Rules\Privy;

use Assetku\DigitalSignature\Rules\Rule;

class PrivyCheckRegistrationStatusRule extends Rule
{
    /**
     * Get rules for validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required|string'
        ];
    }
}
