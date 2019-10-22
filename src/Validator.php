<?php

namespace Assetku\DigitalSignature;

use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Rules\Rule;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;

class Validator
{
    /**
     * Validate the given data with the given rule.
     *
     * @param  array  $data
     * @param  Rule  $rule
     * @throws DigitalSignatureValidatorException
     */
    public function validate(array $data, Rule $rule)
    {
        try {
            app(Factory::class)
                ->make($data, $rule->rules(), $rule->messages(), $rule->customAttributes())
                ->validate();
        } catch (ValidationException $e) {
            throw DigitalSignatureValidatorException::failed($e->getMessage(), $e->errors());
        }
    }
}
