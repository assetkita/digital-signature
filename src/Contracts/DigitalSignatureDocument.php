<?php

namespace Assetku\DigitalSignature\Contracts;

use Illuminate\Http\UploadedFile;

interface DigitalSignatureDocument
{
    /**
     * @return string
     */
    public function getDigitalSignatureDocumentTitle();

    /**
     * @return string
     */
    public function getDigitalSignatureDocumentType();

    /**
     * @return string
     */
    public function getDigitalSignatureDocumentOwnerAccountId();

    /**
     * @return UploadedFile
     */
    public function getDigitalSignatureDocumentFile();

    /**
     * @return DigitalSignatureDocumentRecipient[]
     */
    public function getDigitalSignatureDocumentRecipients();
}
