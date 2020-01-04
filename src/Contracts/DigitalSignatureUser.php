<?php

namespace Assetku\DigitalSignature\Contracts;

use Illuminate\Http\UploadedFile;

interface DigitalSignatureUser
{
    /**
     * @return string
     */
    public function getDigitalSignatureUserEmail();

    /**
     * @return string
     */
    public function getDigitalSignatureUserPhone();

    /**
     * @return UploadedFile
     */
    public function getDigitalSignatureUserSelfie();

    /**
     * @return UploadedFile
     */
    public function getDigitalSignatureUserIdentityCard();

    /**
     * @return string
     */
    public function getDigitalSignatureUserIdentityNumber();

    /**
     * @return string
     */
    public function getDigitalSignatureUserName();

    /**
     * @return string
     */
    public function getDigitalSignatureUserDateOfBirth();
}
