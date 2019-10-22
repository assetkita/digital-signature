<?php

namespace Assetku\DigitalSignature\Rules;

abstract class Rule
{
    /**
     * Get rules for validation
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Get messages for validation
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Get custom attributes for validation
     *
     * @return array
     */
    public function customAttributes()
    {
        return [];
    }
}
