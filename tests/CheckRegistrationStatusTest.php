<?php

namespace Assetku\DigitalSignature\Tests;

use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use GuzzleHttp\Exception\GuzzleException;

class CheckRegistrationStatusTest extends TestCase
{
    /**
     * Test for verified registration.
     *
     * @throws GuzzleException
     */
    public function testVerifiedRegistration()
    {
        $token = '9fce108d0276a9cdbcc6bb11d924380a1ec41576f8504276640b17c82d7de36f';

        try {
            $user = \DigitalSignatureService::checkRegistrationStatus($token);
        } catch (DigitalSignatureCheckRegistrationStatusException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }

        $this->assertTrue($user->isStatusVerified());
    }

    /**
     * Test for waiting registration.
     *
     * @throws GuzzleException
     */
    public function testWaitingRegistration()
    {
        $token = '897fd0ba37c672980afecc92a979722b26f112e29554b26e82665de05a35a241';

        try {
            $user = \DigitalSignatureService::checkRegistrationStatus($token);
        } catch (DigitalSignatureCheckRegistrationStatusException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }

        $this->assertTrue($user->isStatusWaiting());
    }

    /**
     * Test for invalid registration.
     *
     * @throws GuzzleException
     */
    public function testInvalidRegistration()
    {
        $token = '02f70eaeaa0bc10d50d8181347a00af1b1a87fa63d3da8d37ceb58eafa366ab0';

        try {
            $user = \DigitalSignatureService::checkRegistrationStatus($token);
        } catch (DigitalSignatureCheckRegistrationStatusException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }

        $this->assertTrue($user->isStatusInvalid());
    }
}
