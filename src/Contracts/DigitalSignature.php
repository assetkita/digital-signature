<?php

namespace Assetku\DigitalSignature\Contracts;

use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Users\User;
use GuzzleHttp\Exception\GuzzleException;

interface DigitalSignature
{
    /**
     * Register a user to digital signature provider
     *
     * @param  array  $data
     * @return User
     * @throws GuzzleException
     * @throws DigitalSignatureValidatorException
     * @throws DigitalSignatureRegistrationException
     */
    public function register(array $data);

    /**
     * Check the registered user status in digital signature provider
     *
     * @param  string  $token
     * @return User
     * @throws GuzzleException
     * @throws DigitalSignatureValidatorException
     * @throws DigitalSignatureCheckRegistrationStatusException
     */
    public function checkRegistrationStatus(string $token);

    /**
     * Upload a document to digital signature provider
     *
     * @param  array  $data
     * @return Document
     * @throws GuzzleException
     * @throws DigitalSignatureValidatorException
     * @throws DigitalSignatureUploadDocumentException
     */
    public function uploadDocument(array $data);

    /**
     * Check the uploaded document status in digital signature provider
     *
     * @param  string  $token
     * @return Document
     * @throws GuzzleException
     * @throws DigitalSignatureValidatorException
     * @throws DigitalSignatureCheckDocumentStatusException
     */
    public function checkDocumentStatus(string $token);

    /**
     * Get enterprise token
     *
     * @return string
     */
    public function getEnterpriseToken();

    /**
     * Get web SDK endpoint
     *
     * @return string
     */
    public function getWebSDKEndpoint();
}
