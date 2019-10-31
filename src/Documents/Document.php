<?php

namespace Assetku\DigitalSignature\Documents;

use Assetku\DigitalSignature\Documents\DocumentRecipients\DocumentRecipient;

abstract class Document
{
    /**
     * @var string
     */
    const DOCUMENT_TYPE_SERIAL = 'Serial';

    /**
     * @var string
     */
    const DOCUMENT_TYPE_PARALLEL = 'Parallel';

    /**
     * @var string
     */
    const STATUS_COMPLETED = 'Completed';

    /**
     * @var string
     */
    const STATUS_IN_PROGRESS = 'In Progress';

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
        return $this->status === static::STATUS_COMPLETED;
    }

    /**
     * Determine whether document's status is in progress
     *
     * @return string
     */
    public function isStatusInProgress()
    {
        return $this->status === static::STATUS_IN_PROGRESS;
    }
}
