<?php

namespace Assetku\DigitalSignature;

use Assetku\DigitalSignature\Contracts\DigitalSignature as DigitalSignatureContract;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use GuzzleHttp\Exception\GuzzleException;

class DigitalSignature implements DigitalSignatureContract
{
    /**
     * @var DigitalSignature
     */
    protected $digitalSignature;

    /**
     * DigitalSignature constructor.
     */
    public function __construct()
    {
        $this->digitalSignature = resolve(DigitalSignatureContract::class);
    }

    /**
     * Register the user to digital signature provider
     *
     * @param  array  $data
     * @return \Assetku\DigitalSignature\Users\User
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register(array $data)
    {
        try {
            $user = $this->digitalSignature->register($data);

            return $user;
        } catch (DigitalSignatureRegistrationException $e) {
            throw $e;
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Check the registered user status in digital signature provider
     *
     * @param  string  $token
     * @return \Assetku\DigitalSignature\Users\User
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkRegistrationStatus(string $token)
    {
        try {
            $user = $this->digitalSignature->checkRegistrationStatus($token);

            return $user;
        } catch (DigitalSignatureCheckRegistrationStatusException $e) {
            throw $e;
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Upload a document to digital signature provider
     *
     * @param  array  $data
     * @return \Assetku\DigitalSignature\Documents\Document
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadDocument(array $data)
    {
        try {
            $document = $this->digitalSignature->uploadDocument($data);

            return $document;
        } catch (DigitalSignatureUploadDocumentException $e) {
            throw $e;
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Check the uploaded document status in digital signature provider
     *
     * @param  string  $token
     * @return \Assetku\DigitalSignature\Documents\Document
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkDocumentStatus(string $token)
    {
        try {
            $document = $this->digitalSignature->checkDocumentStatus($token);

            return $document;
        } catch (DigitalSignatureCheckDocumentStatusException $e) {
            throw $e;
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Get enterprise token
     *
     * @return string
     */
    public function getEnterpriseToken()
    {
        return $this->digitalSignature->getEnterpriseToken();
    }

    /**
     * Get web SDK endpoint
     *
     * @return string
     */
    public function getWebSDKEndpoint()
    {
        return $this->digitalSignature->getWebSDKEndpoint();
    }
}
