<?php

namespace Assetku\DigitalSignature\Documents;

use Assetku\DigitalSignature\DocumentRecipients\DocumentRecipient;

abstract class Document
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var DocumentRecipient[]
     */
    protected $recipients;

    /**
     * Get serial type
     *
     * @return string
     */
    abstract public function getTypeSerial();

    /**
     * Get serial parallel
     *
     * @return string
     */
    abstract public function getTypeParallel();

    /**
     * Get completed status
     *
     * @return string
     */
    abstract public function getStatusCompleted();

    /**
     * Get in progress status
     *
     * @return string
     */
    abstract public function getStatusInProgress();

    /**
     * Get the digital signature document's token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the digital signature document's url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the digital signature document's recipients
     *
     * @return DocumentRecipient[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Determine whether document's status is completed
     *
     * @return string
     */
    public function isStatusCompleted()
    {
        return $this->status === $this->getStatusCompleted();
    }

    /**
     * Determine whether document's status is in progress
     *
     * @return string
     */
    public function isStatusInProgress()
    {
        return $this->status === $this->getStatusInProgress();
    }
}
