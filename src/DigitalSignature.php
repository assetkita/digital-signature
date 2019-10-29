<?php

namespace Assetku\DigitalSignature;

use Assetku\DigitalSignature\Contracts\DigitalSignature as DigitalSignatureContract;
use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Documents\DocumentRecipients\DocumentRecipient;
use Assetku\DigitalSignature\Documents\DocumentRecipients\Privy\PrivyDocumentRecipient;
use Assetku\DigitalSignature\Documents\Privy\PrivyDocument;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureDriverException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Users\Privy\PrivyUser;
use Assetku\DigitalSignature\Users\User;
use GuzzleHttp\Exception\GuzzleException;

class DigitalSignature
{
    /**
     * @var DigitalSignature
     */
    protected $digitalSignature;

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
     * DigitalSignature constructor.
     *
     * @throws DigitalSignatureDriverException
     */
    public function __construct()
    {
        $this->digitalSignature = resolve(DigitalSignatureContract::class);

        try {
            $this->setUser();
            $this->setDocument();
            $this->setDocumentRecipient();
        } catch (DigitalSignatureDriverException $e) {
            throw $e;
        }
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

    /**
     * Set digital signature user
     *
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureDriverException
     */
    public function setUser()
    {
        switch (config('digital-signature.default')) {
            case 'privy':
                $this->user = PrivyUser::class;
                break;
            default:
                throw DigitalSignatureDriverException::unknownDriver();
                break;
        }
    }

    /**
     * Get digital signature user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set digital signature document
     *
     * @throws DigitalSignatureDriverException
     */
    public function setDocument()
    {
        switch (config('digital-signature.default')) {
            case 'privy':
                $this->document = PrivyDocument::class;
                break;
            default:
                throw DigitalSignatureDriverException::unknownDriver();
                break;
        }
    }

    /**
     * Get digital signature document
     *
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set digital signature document recipient
     *
     * @throws DigitalSignatureDriverException
     */
    public function setDocumentRecipient()
    {
        switch (config('digital-signature.default')) {
            case 'privy':
                $this->documentRecipient = PrivyDocumentRecipient::class;
                break;
            default:
                throw DigitalSignatureDriverException::unknownDriver();
                break;
        }
    }

    /**
     * Get digital signature document recipient
     *
     * @return DocumentRecipient
     */
    public function getDocumentRecipient()
    {
        return $this->documentRecipient;
    }
}
