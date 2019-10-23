<?php

namespace Assetku\DigitalSignature\tests;

use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
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
        $data = [
            'email'    => $email = $this->faker->safeEmail,
            'phone'    => $phone = '08' . $this->randomPhoneNumbers(),
            'selfie'   => $this->generateImage('selfie'),
            'ktp'      => $this->generateImage('ktp'),
            'identity' => [
                'nik'           => mt_rand(111111111111111, 999999999999999) . rand(1, 9),
                'name'          => $this->faker->name,
                'tanggal_lahir' => $this->faker->date()
            ]
        ];

        try {
            $user = \DigitalSignature::register($data);

            $phone = str_replace_first('0', '+62', $phone);

            $this->assertTrue(
                $user->getEmail() === $email &&
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
        $data = [
            'email'    => $email = $this->faker->safeEmail,
            'phone'    => $phone = '+628' . $this->randomPhoneNumbers(),
            'selfie'   => $this->generateImage('selfie'),
            'ktp'      => $this->generateImage('ktp'),
            'identity' => [
                'nik'           => mt_rand(111111111111111, 999999999999999) . rand(1, 9),
                'name'          => $this->faker->name,
                'tanggal_lahir' => $this->faker->date()
            ]
        ];

        try {
            $user = \DigitalSignature::register($data);

            $this->assertTrue(
                $user->getEmail() === $email &&
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
    public function testSuccessfulRegistrationWithAbnormalPhone1()
    {
        $data = [
            'email'    => $email = $this->faker->safeEmail,
            'phone'    => $phone = '(+62)8' . $this->randomPhoneNumbers(),
            'selfie'   => $this->generateImage('selfie'),
            'ktp'      => $this->generateImage('ktp'),
            'identity' => [
                'nik'           => mt_rand(111111111111111, 999999999999999) . rand(1, 9),
                'name'          => $this->faker->name,
                'tanggal_lahir' => $this->faker->date()
            ]
        ];

        try {
            $user = \DigitalSignature::register($data);

            $phone = str_replace_first('(', '', $phone);
            $phone = str_replace_first(')', '', $phone);

            $this->assertTrue(
                $user->getEmail() === $email &&
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
        $data = [
            'email'    => $email = $this->faker->safeEmail,
            'phone'    => $phone = '628' . $this->randomPhoneNumbers(),
            'selfie'   => $this->generateImage('selfie'),
            'ktp'      => $this->generateImage('ktp'),
            'identity' => [
                'nik'           => mt_rand(111111111111111, 999999999999999) . rand(1, 9),
                'name'          => $this->faker->name,
                'tanggal_lahir' => $this->faker->date()
            ]
        ];

        try {
            $user = \DigitalSignature::register($data);

            $phone = "+{$phone}";

            $this->assertTrue(
                $user->getEmail() === $email &&
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
     * Get random phone numbers
     *
     * @return int
     */
    protected function randomPhoneNumbers()
    {
        do {
            $numbers = mt_rand(1111111111, 9999999999);
        } while(substr($numbers, 0, 1) === '4');

        return $numbers;
    }

    /**
     * Generate random image for the given name
     *
     * @param  string  $name
     * @return UploadedFile
     */
    protected function generateImage(string $name)
    {
        $fileName = "{$name}.jpeg";

        \Storage::disk('public')->put($fileName, file_get_contents('https://picsum.photos/200?'.rand(1, 99)));

        return new UploadedFile(\Storage::disk('public')->path($fileName), $fileName, 'image/jpeg', null, null, true);
    }
}
