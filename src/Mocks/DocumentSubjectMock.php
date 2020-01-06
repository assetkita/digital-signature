<?php

namespace Assetku\DigitalSignature\Mocks;

use Assetku\DigitalSignature\Builders\Privy\PrivyUploadDocumentRecipientBuilder;
use Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentSubject;
use Illuminate\Http\UploadedFile;

class DocumentSubjectMock implements DigitalSignatureDocumentSubject
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
     * DocumentSubjectMock constructor.
     */
    public function __construct()
    {
        $this->title = 'Syarat & Ketentuan Pengguna';

        $this->type = 'Serial';

        $this->ownerPrivyId = 'YO0880';

        $this->ownerEnterpriseToken = \DigitalSignature::getEnterpriseToken();

        $this->document = $this->generatePdf('syarat & ketentuan');

        $this->recipients = [
            new DocumentRecipientSubjectMock,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureDocumentTitle()
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureDocumentType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureDocumentOwnerAccountId()
    {
        return $this->ownerPrivyId;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureDocumentFile()
    {
        return $this->document;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureDocumentRecipients()
    {
        return $this->recipients;
    }

    /**
     * Generate random pdf for the given name
     *
     * @param  string  $name
     * @return UploadedFile
     */
    protected function generatePdf(string $name)
    {
        $fileName = "{$name}.pdf";

        \Storage::disk('public')->put($fileName,
            file_get_contents('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'));

        return new UploadedFile(\Storage::disk('public')->path($fileName), $fileName, 'application/pdf', null, null,
            true);
    }
}
