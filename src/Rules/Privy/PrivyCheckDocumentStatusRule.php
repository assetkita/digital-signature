<?php

namespace Assetku\DigitalSignature\Rules\Privy;

use Assetku\DigitalSignature\Rules\Rule;

class PrivyCheckDocumentStatusRule extends Rule
{
    /**
     * Get rules for validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docToken' => 'required|string'
        ];
    }
}
