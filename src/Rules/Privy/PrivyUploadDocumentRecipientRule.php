<?php

namespace Assetku\DigitalSignature\Rules\Privy;

use Assetku\DigitalSignature\Rules\Rule;
use Illuminate\Validation\Rule as ValidationRule;

class PrivyUploadDocumentRecipientRule extends Rule
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'privyId'         => 'required|string|max:255',
            'type'            => [
                'required',
                'string',
                ValidationRule::in(['Signer', 'Reviewer']),
            ],
            'enterpriseToken' => 'nullable|string|max:255',
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            'recipients.*.type.in' => ":attribute harus berupa Signer atau Reviewer",
        ];
    }
}
