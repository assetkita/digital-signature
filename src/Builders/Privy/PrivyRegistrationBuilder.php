<?php

namespace Assetku\DigitalSignature\Builders\Privy;

use Assetku\DigitalSignature\Builders\Serializable;
use Assetku\DigitalSignature\Contracts\DigitalSignatureUser;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Rules\Privy\PrivyRegisterRule;
use Assetku\DigitalSignature\Validator;
use Illuminate\Http\UploadedFile;

class PrivyRegistrationBuilder implements Serializable
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var UploadedFile
     */
    protected $selfie;

    /**
     * @var UploadedFile
     */
    protected $identityCard;

    /**
     * @var string
     */
    protected $identityNumber;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $dateOfBirth;

    /**
     * PrivyRegistrationBuilder constructor.
     *
     * @param  DigitalSignatureUser  $user
     * @throws DigitalSignatureValidatorException
     */
    public function __construct(DigitalSignatureUser $user)
    {
        $this->email = $user->getDigitalSignatureUserEmail();
        $this->phone = $user->getDigitalSignatureUserPhone();
        $this->selfie = $user->getDigitalSignatureUserSelfie();
        $this->identityCard = $user->getDigitalSignatureUserIdentityCard();
        $this->identityNumber = $user->getDigitalSignatureUserIdentityNumber();
        $this->name = $user->getDigitalSignatureUserName();
        $this->dateOfBirth = $user->getDigitalSignatureUserDateOfBirth();

        $this->normalizePhone();

        try {
            $this->validate();
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return [
            'email'    => $this->email,
            'phone'    => $this->phone,
            'selfie'   => $this->selfie,
            'ktp'      => $this->identityCard,
            'identity' => [
                'nik'           => $this->identityNumber,
                'name'          => $this->name,
                'tanggal_lahir' => $this->dateOfBirth,
            ],
        ];
    }

    /**
     * Validate registration data
     *
     * @return void
     * @throws DigitalSignatureValidatorException
     */
    protected function validate()
    {
        $validator = new Validator;

        try {
            $validator->validate($this->serialize(), new PrivyRegisterRule);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }
    }

    /**
     * Privy only accept pattern 08123... or +628123... not (+62)8123... or 628123... so we need to normalizing it
     *
     * @return void
     */
    protected function normalizePhone()
    {
        $patterns = [
            '/^\(\+62\)/',
            '/^62/'
        ];

        foreach ($patterns as $pattern) {
            // replace abnormal pattern with normal pattern
            $this->phone = preg_replace($pattern, '+62', $this->phone);
        }

        // strip whitespace everywhere
        $this->phone = str_replace(' ', '', $this->phone);
    }
}
