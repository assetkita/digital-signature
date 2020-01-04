<?php

namespace Assetku\DigitalSignature\Contracts;

interface DigitalSignatureDocumentRecipient
{
    /**
     * @return string
     */
    public function getDigitalSignatureDocumentRecipientAccountId();

    /**
     * @return string
     */
    public function getDigitalSignatureDocumentRecipientType();
}
