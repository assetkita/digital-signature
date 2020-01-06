<?php

namespace Assetku\DigitalSignature\Mocks;

use Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentRecipientSubject;

class DocumentRecipientSubjectMock implements DigitalSignatureDocumentRecipientSubject
{
    /**
     * @var string
     */
    protected $recipientPrivyId;

    /**
     * @var string
     */
    protected $recipientType;

    /**
     * DocumentSubjectMock constructor.
     */
    public function __construct()
    {
        $this->recipientPrivyId = 'YO0880';

        $this->recipientType = 'Signer';
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureDocumentRecipientAccountId()
    {
        return $this->recipientPrivyId;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureDocumentRecipientType()
    {
        return $this->recipientType;
    }
}
