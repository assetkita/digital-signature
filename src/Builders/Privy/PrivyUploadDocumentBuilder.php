<?php

namespace Assetku\DigitalSignature\Builders\Privy;

use Assetku\DigitalSignature\Builders\Serializable;
use Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentSubject;
use Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentRecipientSubject;
use Assetku\DigitalSignature\DocumentRecipients\Privy\PrivyDocumentRecipient;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Rules\Privy\PrivyUploadDocumentRule;
use Assetku\DigitalSignature\Validator;
use Illuminate\Http\UploadedFile;

class PrivyUploadDocumentBuilder implements Serializable
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $ownerPrivyId;

    /**
     * @var string
     */
    protected $ownerEnterpriseToken;

    /**
     * @var UploadedFile
     */
    protected $document;

    /**
     * @var PrivyUploadDocumentRecipientBuilder[]
     */
    protected $recipients;

    /**
     * PrivyUploadDocumentBuilder constructor.
     *
     * @param  DigitalSignatureDocumentSubject  $document
     * @throws DigitalSignatureValidatorException
     */
    public function __construct(DigitalSignatureDocumentSubject $document)
    {
        $this->title = $document->getDigitalSignatureDocumentTitle();
        $this->type = $document->getDigitalSignatureDocumentType();
        $this->ownerPrivyId = $document->getDigitalSignatureDocumentOwnerAccountId();
        $this->ownerEnterpriseToken = \DigitalSignatureService::getEnterpriseToken();
        $this->document = $document->getDigitalSignatureDocumentFile();

        $this->recipients = array_map(function (DigitalSignatureDocumentRecipientSubject $documentRecipient) {
            return new PrivyUploadDocumentRecipientBuilder($documentRecipient);
        }, $document->getDigitalSignatureDocumentRecipients());

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
            'documentTitle' => $this->title,
            'docType'       => $this->type,
            'owner'         => [
                'privyId'         => $this->ownerPrivyId,
                'enterpriseToken' => $this->ownerEnterpriseToken,
            ],
            'document'      => $this->document,
            'recipients'    => array_map(function (PrivyUploadDocumentRecipientBuilder $documentRecipientBuilder) {
                return $documentRecipientBuilder->serialize();
            }, $this->recipients),
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
            $validator->validate($this->serialize(), new PrivyUploadDocumentRule);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }
    }
}
