<?php

namespace Assetku\DigitalSignature\Services;

use Assetku\DigitalSignature\Contracts\DigitalSignature;
use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Documents\Privy\PrivyDocument;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\HTTPClient;
use Assetku\DigitalSignature\Rules\Privy\PrivyCheckDocumentStatusRule;
use Assetku\DigitalSignature\Rules\Privy\PrivyCheckRegistrationStatusRule;
use Assetku\DigitalSignature\Rules\Privy\PrivyRegisterRule;
use Assetku\DigitalSignature\Rules\Privy\PrivyUploadDocumentRule;
use Assetku\DigitalSignature\Users\Privy\PrivyUser;
use Assetku\DigitalSignature\Users\User;
use Assetku\DigitalSignature\Validator;
use GuzzleHttp\Exception\GuzzleException;

class Privy implements DigitalSignature
{
    /**
     * @var string
     */
    private $merchantKey;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $enterpriseToken;

    /**
     * @var string
     */
    private $webSDKEndpoint;

    /**
     * @var HTTPClient
     */
    protected $httpClient;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Privy constructor.
     */
    public function __construct()
    {
        $this->merchantKey = config('digital-signature.services.privy.merchant_key');
        $this->username = config('digital-signature.services.privy.username');
        $this->password = config('digital-signature.services.privy.password');

        if (\App::environment('production')) {
            $this->endpoint = config('digital-signature.services.privy.endpoint.production');
            $this->enterpriseToken = config('digital-signature.services.privy.enterprise_token.production');
            $this->webSDKEndpoint = config('digital-signature.services.privy.web_sdk_endpoint.production');
        } else {
            $this->endpoint = config('digital-signature.services.privy.endpoint.development');
            $this->enterpriseToken = config('digital-signature.services.privy.enterprise_token.development');
            $this->webSDKEndpoint = config('digital-signature.services.privy.web_sdk_endpoint.development');
        }

        $this->initHttpClient();

        $this->validator = new Validator;
    }

    /**
     * Register a user to digital signature provider
     *
     * @param  array  $data
     * @return User
     * @throws DigitalSignatureRegistrationException
     * @throws DigitalSignatureValidatorException
     * @throws GuzzleException
     */
    public function register(array $data)
    {
        try {
            $this->validator->validate($data, new PrivyRegisterRule);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }

        try {
            $response = $this->httpClient->post('registration', $data, HTTPClient::POST_MULTIPART);

            $contents = json_decode($response->getBody()->getContents());

            // on success registration
            if ($response->getStatusCode() === 201) {
                return new PrivyUser($contents->data);
            }

            // on failed registration
            if ($response->getStatusCode() === 422) {
                throw DigitalSignatureRegistrationException::failed($contents->message, $contents->errors);
            }

            throw DigitalSignatureRegistrationException::unknown();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Check the registered user status in digital signature provider
     *
     * @param  string  $token
     * @return User
     * @throws DigitalSignatureCheckRegistrationStatusException
     * @throws DigitalSignatureValidatorException
     * @throws GuzzleException
     */
    public function checkRegistrationStatus(string $token)
    {
        $data = [
            'token' => $token
        ];

        try {
            $this->validator->validate($data, new PrivyCheckRegistrationStatusRule);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }

        try {
            $response = $this->httpClient->post('registration/status', $data);

            $contents = json_decode($response->getBody()->getContents());

            // on success registration status
            if ($response->getStatusCode() === 201) {
                return new PrivyUser($contents->data);
            }

            // on failed registration status
            if ($response->getStatusCode() === 422) {
                throw DigitalSignatureCheckRegistrationStatusException::failed($contents->message,
                    $contents->errors);
            }

            // on not found registration status
            if ($response->getStatusCode() === 404) {
                throw DigitalSignatureCheckRegistrationStatusException::notFound($contents->message);
            }

            throw DigitalSignatureCheckRegistrationStatusException::unknown();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Upload a document to digital signature provider
     *
     * @param  array  $data
     * @return Document
     * @throws DigitalSignatureUploadDocumentException
     * @throws DigitalSignatureValidatorException
     * @throws GuzzleException
     */
    public function uploadDocument(array $data)
    {
        try {
            $this->validator->validate($data, new PrivyUploadDocumentRule);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }

        try {
            $response = $this->httpClient->post('document/upload', $data, HTTPClient::POST_MULTIPART);

            $contents = json_decode($response->getBody()->getContents());

            // on success upload document
            if ($response->getStatusCode() === 201) {
                return new PrivyDocument($contents->data);
            }

            // on failed upload document
            if ($response->getStatusCode() === 422) {
                throw DigitalSignatureUploadDocumentException::failed($contents->message, $contents->errors);
            }

            throw DigitalSignatureUploadDocumentException::unknown();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Check the uploaded document status in digital signature provider
     *
     * @param  string  $token
     * @return Document
     * @throws DigitalSignatureCheckDocumentStatusException
     * @throws DigitalSignatureValidatorException
     * @throws GuzzleException
     */
    public function checkDocumentStatus(string $token)
    {
        $data = [
            'docToken' => $token
        ];

        try {
            $this->validator->validate($data, new PrivyCheckDocumentStatusRule);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }

        try {
            $response = $this->httpClient->get("document/status/{$token}");

            $contents = json_decode($response->getBody()->getContents());

            // on success document status
            if ($response->getStatusCode() === 200) {
                return new PrivyDocument($contents->data);
            }

            // on not found document status
            if ($response->getStatusCode() === 404) {
                throw DigitalSignatureCheckDocumentStatusException::notFound($contents->message);
            }

            throw DigitalSignatureCheckDocumentStatusException::unknown();
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
        return $this->enterpriseToken;
    }

    /**
     * Get web SDK endpoint
     *
     * @return string
     */
    public function getWebSDKEndpoint()
    {
        return $this->webSDKEndpoint;
    }

    /**
     * Initialize the HTTPClient instance
     *
     */
    protected function initHttpClient()
    {
        $this->httpClient = new HTTPClient([
            'base_uri' => $this->endpoint,
            'headers'  => [
                'Merchant-Key' => $this->merchantKey,
                'Accept'       => 'application/json'
            ],
            'auth'     => [
                $this->username,
                $this->password
            ]
        ]);
    }
}
