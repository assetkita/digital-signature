<?php

namespace Assetku\DigitalSignature\tests;

use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Mocks\DocumentMock;
use Assetku\DigitalSignature\Services\PrivyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\UploadedFile;

class UploadDocumentTest extends TestCase
{
    /**
     * Test for successful upload document.
     *
     * @throws GuzzleException
     */
    public function testSuccessfulUploadDocument()
    {
        $mock = new DocumentMock;

        try {
            $document = \DigitalSignature::uploadDocument($mock);

            $recipient = $document->getRecipients()[0];

            $this->assertTrue(
                $document->getToken() !== null &&
                $document->getUrl() !== null &&
                $recipient->getId() === $mock->getDigitalSignatureDocumentOwnerAccountId() &&
                $recipient->getRecipientRole() === $mock->getDigitalSignatureDocumentRecipients()[0]->getDigitalSignatureDocumentRecipientType()
            );
        } catch (DigitalSignatureUploadDocumentException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }
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
