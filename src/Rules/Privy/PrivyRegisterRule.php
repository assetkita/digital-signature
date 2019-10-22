<?php

namespace Assetku\DigitalSignature\Rules\Privy;

use Assetku\DigitalSignature\Rules\Rule;

class PrivyRegisterRule extends Rule
{
    /**
     * Get rules for validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'                  => 'required|email',
            'phone'                  => 'required|string',
            'selfie'                 => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'ktp'                    => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'identity'               => 'required|array',
            'identity.nik'           => [
                'required',
                'numeric',
                'digits:16',
                'regex:/[1-9]$/'
            ],
            'identity.name'          => 'required|string|min:3',
            'identity.tanggal_lahir' => 'required|date'
        ];
    }

    /**
     * Get messages for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'identity.nik.regex' => "Digit terakhir :attribute tidak boleh berupa 0"
        ];
    }
}
