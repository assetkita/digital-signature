<?php

namespace Assetku\DigitalSignature\Mocks;

use Assetku\DigitalSignature\Contracts\DigitalSignatureUserSubject;
use Faker\Factory;
use Illuminate\Http\UploadedFile;

class UserSubjectMock implements DigitalSignatureUserSubject
{
    /**
     * @var Factory
     */
    protected $faker;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var UploadedFile
     */
    protected $selfie;

    /**
     * @var UploadedFile
     */
    protected $identityCard;

    /**
     * @var string
     */
    protected $identityNumber;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $dateOfBirth;

    /**
     * User constructor.
     *
     * @param  string  $phonePrefix
     */
    public function __construct(string $phonePrefix)
    {
        $this->faker = Factory::create('id_ID');

        $this->email = $this->faker->safeEmail;

        $this->phone = "{$phonePrefix}{$this->randomPhoneNumbers()}";

        $this->selfie = $this->generateImage('selfie');

        $this->identityCard = $this->generateImage('ktp');

        $this->identityNumber = mt_rand(111111111111111, 999999999999999) . rand(1, 9);

        $this->name = $this->faker->name;

        $this->dateOfBirth = $this->faker->date();
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureUserEmail()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureUserPhone()
    {
        return $this->phone;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureUserSelfie()
    {
        return $this->selfie;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureUserIdentityCard()
    {
        return $this->identityCard;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureUserIdentityNumber()
    {
        return $this->identityNumber;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureUserName()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getDigitalSignatureUserDateOfBirth()
    {
        return $this->dateOfBirth;
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
