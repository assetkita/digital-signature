<?php

namespace Assetku\DigitalSignature\Builders\Privy;

use Assetku\DigitalSignature\Builders\Serializable;
use Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentRecipientSubject;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Rules\Privy\PrivyUploadDocumentRecipientRule;
use Assetku\DigitalSignature\Validator;

class PrivyUploadDocumentRecipientBuilder implements Serializable
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
     * PrivyUploadDocumentRecipientBuilder constructor.
     *
     * @param  DigitalSignatureDocumentRecipientSubject  $documentRecipient
     */
    public function __construct(DigitalSignatureDocumentRecipientSubject $documentRecipient)
    {
        $this->recipientPrivyId = $documentRecipient->getDigitalSignatureDocumentRecipientAccountId();
        $this->recipientType = $documentRecipient->getDigitalSignatureDocumentRecipientType();
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return [
            'privyId'         => $this->recipientPrivyId,
            'type'            => $this->recipientType,
            'enterpriseToken' => null
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
            $validator->validate($this->serialize(), new PrivyUploadDocumentRecipientRule);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }
    }
}
