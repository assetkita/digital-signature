<?php

namespace Assetku\DigitalSignature\Rules\Privy;

use Assetku\DigitalSignature\Rules\Rule;
use Illuminate\Validation\Rule as ValidationRule;

class PrivyUploadDocumentRule extends Rule
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'documentTitle'         => 'required|string',
            'docType'               => [
                'required',
                'string',
                ValidationRule::in(['Serial', 'Parallel']),
            ],
            'owner'                 => 'required|array',
            'owner.privyId'         => 'required|string|max:255',
            'owner.enterpriseToken' => 'required|string|max:255',
            'document'              => 'required|file|mimes:pdf|max:2048',
            'recipients'            => 'required|array|min:1',
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            'docType.in' => ":attribute harus berupa Serial atau Parallel",
        ];
    }
}
