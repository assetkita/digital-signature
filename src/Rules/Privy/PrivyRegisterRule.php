<?php

namespace Assetku\DigitalSignature\Rules\Privy;

use Assetku\DigitalSignature\Rules\Rule;

class PrivyRegisterRule extends Rule
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email'                  => 'required|email|min:6',
            'phone'                  => 'required|string|min:10',
            'selfie'                 => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'ktp'                    => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'identity'               => 'required|array',
            'identity.nik'           => [
                'required',
                'string',
                'digits:16',
                'regex:/[1-9]$/',
            ],
            'identity.name'          => 'required|string|min:3',
            'identity.tanggal_lahir' => 'required|date',
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            'identity.nik.regex' => "Karakter terakhir :attribute tidak boleh berupa 0",
        ];
    }
}
