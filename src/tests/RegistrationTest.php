<?php

namespace Assetku\DigitalSignature\tests;

use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Mocks\UserMock;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\UploadedFile;

class RegistrationTest extends TestCase
{
    /**
     * Test for successful registration.
     *
     * @throws GuzzleException
     */
    public function testSuccessfulRegistrationWithNormalPhone1()
    {
        $mock = new UserMock('08');

        try {
            $user = \DigitalSignature::register($mock);

            $phone = str_replace_first('0', '+62', $mock->getDigitalSignatureUserPhone());

            $this->assertTrue(
                $user->getEmail() === $mock->getDigitalSignatureUserEmail() &&
                $user->getPhone() === $phone &&
                $user->getToken() !== null &&
                $user->isStatusWaiting()
            );
        } catch (DigitalSignatureRegistrationException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Test for successful registration.
     *
     * @throws GuzzleException
     */
    public function testSuccessfulRegistrationWithNormalPhone2()
    {
        $mock = new UserMock('+628');

        try {
            $user = \DigitalSignature::register($mock);

            $this->assertTrue(
                $user->getEmail() === $mock->getDigitalSignatureUserEmail() &&
                $user->getPhone() === $mock->getDigitalSignatureUserPhone() &&
                $user->getToken() !== null &&
                $user->isStatusWaiting()
            );
        } catch (DigitalSignatureRegistrationException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Test for successful registration.
     *
     * @throws GuzzleException
     */
    public function testSuccessfulRegistrationWithAbnormalPhone1()
    {
        $mock = new UserMock('(+62)8');

        try {
            $user = \DigitalSignature::register($mock);

            $phone = str_replace_first('(', '', $mock->getDigitalSignatureUserPhone());
            $phone = str_replace_first(')', '', $phone);

            $this->assertTrue(
                $user->getEmail() === $mock->getDigitalSignatureUserEmail() &&
                $user->getPhone() === $phone &&
                $user->getToken() !== null &&
                $user->isStatusWaiting()
            );
        } catch (DigitalSignatureRegistrationException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Test for successful registration.
     *
     * @throws GuzzleException
     */
    public function testSuccessfulRegistrationWithAbnormalPhone2()
    {
        $mock = new UserMock('628');

        try {
            $user = \DigitalSignature::register($mock);

            $phone = "+{$mock->getDigitalSignatureUserPhone()}";

            $this->assertTrue(
                $user->getEmail() === $mock->getDigitalSignatureUserEmail() &&
                $user->getPhone() === $phone &&
                $user->getToken() !== null &&
                $user->isStatusWaiting()
            );
        } catch (DigitalSignatureRegistrationException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (DigitalSignatureValidatorException $e) {
            dd($e->getCode(), $e->getMessage(), $e->getErrors());
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}
