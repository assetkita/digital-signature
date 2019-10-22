<?php

namespace Assetku\DigitalSignature\tests;

use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use GuzzleHttp\Exception\GuzzleException;

class CheckDocumentStatusTest extends TestCase
{
    /**
     * Test for completed document.
     *
     * @throws GuzzleException
     */
    public function testCompletedDocument()
    {
        $token = 'da6bb9c5e7b48a76aee4e6591cc07c2e2408e93e262ac892eade5a7a93977654';

        try {
            $document = \DigitalSignature::checkDocumentStatus($token);
        } catch (DigitalSignatureCheckDocumentStatusException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }

        $this->assertTrue($document->isStatusCompleted());
    }

    /**
     * Test for in progress document.
     *
     * @throws GuzzleException
     */
    public function testInProgressDocument()
    {
        $token = '6bb67943f43a9b24139046fd332b442b7aed5270edb3031842b650089647ecf3';

        try {
            $document = \DigitalSignature::checkDocumentStatus($token);
        } catch (DigitalSignatureCheckDocumentStatusException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }

        $this->assertTrue($document->isStatusInProgress());
    }
}
