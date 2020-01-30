<?php

namespace Assetku\DigitalSignature;

use Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentSubject;
use Assetku\DigitalSignature\Contracts\DigitalSignatureUserSubject;
use Assetku\DigitalSignature\DocumentRecipients\DocumentRecipient;
use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Services\Service;
use Assetku\DigitalSignature\Users\User;
use GuzzleHttp\Exception\GuzzleException;

class DigitalSignatureService
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Document
     */
    protected $document;

    /**
     * @var DocumentRecipient
     */
    protected $documentRecipient;

    /**
     * DigitalSignatureService constructor.
     *
     */
    public function __construct()
    {
        $this->driver = \App::make('assetkita.digital_signature_driver');

        $this->service = $this->driver->service();
        $this->user = $this->driver->user();
        $this->document = $this->driver->document();
        $this->documentRecipient = $this->driver->documentRecipient();
    }

    /**
     * Register the user to digital signature provider
     *
     * @param  \Assetku\DigitalSignature\Contracts\DigitalSignatureUserSubject  $user
     * @return \Assetku\DigitalSignature\Users\User
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register(DigitalSignatureUserSubject $user)
    {
        try {
            return $this->service->register($user);
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
            return $this->service->checkRegistrationStatus($token);
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
     * @param  \Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentSubject  $document
     * @return \Assetku\DigitalSignature\Documents\Document
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadDocument(DigitalSignatureDocumentSubject $document)
    {
        try {
            return $this->service->uploadDocument($document);
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
            return $this->service->checkDocumentStatus($token);
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
        return $this->service->getEnterpriseToken();
    }

    /**
     * Get web SDK endpoint
     *
     * @return string
     */
    public function getWebSDKEndpoint()
    {
        return $this->service->getWebSDKEndpoint();
    }

    /**
     * Get digital signature user
     *
     * @return \Assetku\DigitalSignature\Users\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get digital signature document
     *
     * @return \Assetku\DigitalSignature\Documents\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Get digital signature document recipient
     *
     * @return \Assetku\DigitalSignature\DocumentRecipients\DocumentRecipient
     */
    public function getDocumentRecipient()
    {
        return $this->documentRecipient;
    }
}
