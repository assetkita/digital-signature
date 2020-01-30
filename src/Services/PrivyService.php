<?php

namespace Assetku\DigitalSignature\Services;

use Assetku\DigitalSignature\Builders\Privy\PrivyRegistrationBuilder;
use Assetku\DigitalSignature\Builders\Privy\PrivyUploadDocumentBuilder;
use Assetku\DigitalSignature\Contracts\DigitalSignatureDocumentSubject;
use Assetku\DigitalSignature\Contracts\DigitalSignatureUserSubject;
use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Documents\Privy\PrivyDocument;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckDocumentStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureCheckRegistrationStatusException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureRegistrationException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureUploadDocumentException;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureValidatorException;
use Assetku\DigitalSignature\Users\Privy\PrivyUser;
use Assetku\DigitalSignature\Users\User;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class PrivyService implements Service
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
     * @var API
     */
    protected $api;

    /**
     * PrivyService constructor.
     */
    public function __construct()
    {
        $this->merchantKey = config('digital-signature.services.privy.merchant_key');
        $this->username = config('digital-signature.services.privy.username');
        $this->password = config('digital-signature.services.privy.password');

        $environment = \App::environment('production') ? 'production' : 'development';

        $this->endpoint = config("digital-signature.services.privy.{$environment}.endpoint");
        $this->enterpriseToken = config("digital-signature.services.privy.{$environment}.enterprise_token");
        $this->webSDKEndpoint = config("digital-signature.services.privy.{$environment}.web_sdk_endpoint");

        $this->initAPI();
    }

    /**
     * Register a user to digital signature provider
     *
     * @param  DigitalSignatureUserSubject  $user
     * @return User
     * @throws DigitalSignatureRegistrationException
     * @throws DigitalSignatureValidatorException
     * @throws GuzzleException
     */
    public function register(DigitalSignatureUserSubject $user)
    {
        try {
            $registration = new PrivyRegistrationBuilder($user);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }

        try {
            $response = $this->api->post('registration', $registration->serialize(), API::POST_MULTIPART);

            $contents = json_decode($response->getBody()->getContents());

            // handle 201 response code
            if ($response->getStatusCode() === Response::HTTP_CREATED) {
                return new PrivyUser($contents->data);
            }

            // handle 422 response code
            if ($response->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
                throw DigitalSignatureRegistrationException::failed($contents->message, $contents->errors);
            }

            // handle 500 response code
            if ($response->getStatusCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
                throw DigitalSignatureRegistrationException::internalServerError($contents->message);
            }

            // handle 503 response code
            if ($response->getStatusCode() === Response::HTTP_SERVICE_UNAVAILABLE) {
                throw DigitalSignatureRegistrationException::serviceUnavailable($contents->message);
            }

            // handle unknown response code
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
     * @throws GuzzleException
     */
    public function checkRegistrationStatus(string $token)
    {
        try {
            $response = $this->api->post('registration/status', ['token' => $token,]);

            $contents = json_decode($response->getBody()->getContents());

            // handle 201 response code
            if ($response->getStatusCode() === Response::HTTP_CREATED) {
                return new PrivyUser($contents->data);
            }

            // handle 422 response code
            if ($response->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
                throw DigitalSignatureCheckRegistrationStatusException::failed($contents->message,
                    $contents->errors);
            }

            // handle 404 response code
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw DigitalSignatureCheckRegistrationStatusException::notFound($contents->message);
            }

            // handle 500 response code
            if ($response->getStatusCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
                throw DigitalSignatureCheckRegistrationStatusException::internalServerError($contents->message);
            }

            // handle 503 response code
            if ($response->getStatusCode() === Response::HTTP_SERVICE_UNAVAILABLE) {
                throw DigitalSignatureCheckRegistrationStatusException::serviceUnavailable($contents->message);
            }

            // handle unknown response code
            throw DigitalSignatureCheckRegistrationStatusException::unknown();
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Upload a document to digital signature provider
     *
     * @param  DigitalSignatureDocumentSubject  $document
     * @return Document
     * @throws DigitalSignatureUploadDocumentException
     * @throws DigitalSignatureValidatorException
     * @throws GuzzleException
     */
    public function uploadDocument(DigitalSignatureDocumentSubject $document)
    {
        try {
            $uploadDocument = new PrivyUploadDocumentBuilder($document);
        } catch (DigitalSignatureValidatorException $e) {
            throw $e;
        }

        try {
            $response = $this->api->post('document/upload', $uploadDocument->serialize(), API::POST_MULTIPART);

            $contents = json_decode($response->getBody()->getContents());

            // handle 201 response code
            if ($response->getStatusCode() === Response::HTTP_CREATED) {
                return new PrivyDocument($contents->data);
            }

            // handle 422 response code
            if ($response->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
                throw DigitalSignatureUploadDocumentException::failed($contents->message, $contents->errors);
            }

            // handle 500 response code
            if ($response->getStatusCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
                throw DigitalSignatureUploadDocumentException::internalServerError($contents->message);
            }

            // handle 503 response code
            if ($response->getStatusCode() === Response::HTTP_SERVICE_UNAVAILABLE) {
                throw DigitalSignatureUploadDocumentException::serviceUnavailable($contents->message);
            }

            // handle unknown response code
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
     * @throws GuzzleException
     */
    public function checkDocumentStatus(string $token)
    {
        try {
            $response = $this->api->get("document/status/{$token}", ['docToken' => $token,]);

            $contents = json_decode($response->getBody()->getContents());

            // handle 200 response code
            if ($response->getStatusCode() === Response::HTTP_OK) {
                return new PrivyDocument($contents->data);
            }

            // handle 404 response code
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw DigitalSignatureCheckDocumentStatusException::notFound($contents->message);
            }

            // handle 500 response code
            if ($response->getStatusCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
                throw DigitalSignatureCheckDocumentStatusException::internalServerError($contents->message);
            }

            // handle 503 response code
            if ($response->getStatusCode() === Response::HTTP_SERVICE_UNAVAILABLE) {
                throw DigitalSignatureCheckDocumentStatusException::serviceUnavailable($contents->message);
            }

            // handle unknown response code
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
     * Initialize the API instance
     *
     * @return void
     */
    protected function initAPI()
    {
        $this->api = new API([
            'base_uri' => $this->endpoint,
            'headers'  => [
                'Merchant-Key' => $this->merchantKey,
                'Accept'       => 'application/json',
            ],
            'auth'     => [
                $this->username,
                $this->password,
            ],
        ]);
    }
}
