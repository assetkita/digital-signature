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
    public function testSuccessfulRegistration()
    {
        $data = [
            'email'    => $email = $this->faker->safeEmail,
            'phone'    => $phone = '08' . mt_rand(1111111111, 9999999999),
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
                $user->getPhone() === str_replace_first('0', '+62', $phone) &&
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
