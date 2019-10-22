<?php

namespace Assetku\DigitalSignature\Rules\Privy;

use Assetku\DigitalSignature\Rules\Rule;

class PrivyUploadDocumentRule extends Rule
{
    /**
     * Get rules for validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'documentTitle'                => 'required|string',
            'docType'                      => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (! $value === 'Serial' || ! $value === 'Parallel') {
                        $fail("{$attribute} harus berupa Serial atau Parallel");
                    }
                }
            ],
            'owner'                        => 'required|array',
            'owner.privyId'                => 'required|string',
            'owner.enterpriseToken'        => 'required|string',
            'document'                     => 'required|file|mimes:pdf|max:2048',
            'recipients'                   => 'required|array',
            'recipients.*.privyId'         => 'required|string',
            'recipients.*.type'            => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (! $value === 'Signer' || ! $value === 'Reviewer') {
                        $fail("{$attribute} harus berupa Signer atau Reviewer");
                    }
                }
            ],
            'recipients.*.enterpriseToken' => 'nullable|string'
        ];
    }
}
