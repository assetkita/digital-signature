<?php

namespace Assetku\DigitalSignature;

use Assetku\DigitalSignature\DocumentRecipients\DocumentRecipient;
use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Services\Service;
use Assetku\DigitalSignature\Users\User;

class Driver
{
    /**
     * @var array
     */
    protected $drivers = [
        'privy' => [
            'service'            => \Assetku\DigitalSignature\Services\PrivyService::class,
            'user'               => \Assetku\DigitalSignature\Users\Privy\PrivyUser::class,
            'document'           => \Assetku\DigitalSignature\Documents\Privy\PrivyDocument::class,
            'document_recipient' => \Assetku\DigitalSignature\DocumentRecipients\Privy\PrivyDocumentRecipient::class,
        ],
    ];

    /**
     * @var array
     */
    protected $driver;

    /**
     * Driver constructor.
     *
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        $this->driver = $this->drivers[$name];
    }

    /**
     * Get registered service from the specified driver
     *
     * @return Service
     */
    public function service()
    {
        return new $this->driver['service'];
    }

    /**
     * Get registered user from the specified driver
     *
     * @return User
     */
    public function user()
    {
        return new $this->driver['user'];
    }

    /**
     * Get registered document from the specified driver
     *
     * @return Document
     */
    public function document()
    {
        return new $this->driver['document'];
    }

    /**
     * Get registered document recipient from the specified driver
     *
     * @return DocumentRecipient
     */
    public function documentRecipient()
    {
        return new $this->driver['document_recipient'];
    }
}
