<?php

namespace Assetku\DigitalSignature\Contracts;

interface DigitalSignatureDocumentRecipientSubject
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
