<?php

namespace Assetku\DigitalSignature\tests;

use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Services\Privy;
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
        $privyId = 'YO0880';
        $type = 'Signer';

        $data = [
            'documentTitle' => 'Syarat & Ketentuan Pengguna',
            'docType'       => 'Serial',
            'owner'         => [
                'privyId'         => $privyId,
                'enterpriseToken' => (new Privy)->getEnterpriseToken()
            ],
            'document'      => $this->generatePdf('syarat & ketentuan'),
            'recipients'    => [
                [
                    'privyId'         => $privyId,
                    'type'            => $type,
                    'enterpriseToken' => null
                ]
            ]
        ];

        try {
            $document = \DigitalSignature::uploadDocument($data);

            $recipient = $document->getRecipients()[0];

            $this->assertTrue(
                $document->getToken() !== null &&
                $document->getUrl() !== null &&
                $recipient->getId() === $privyId &&
                $recipient->getRecipientRole() === $type
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
