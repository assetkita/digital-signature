<?php

namespace Assetku\DigitalSignature\Documents\Privy;

use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Documents\DocumentRecipients\Privy\PrivyDocumentRecipient;

class PrivyDocument extends Document
{
    /**
     * @var string
     */
    const TYPE_SERIAL = 'Serial';

    /**
     * @var string
     */
    const TYPE_PARALLEL = 'Parallel';

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
    protected $status;

    /**
     * @var PrivyDocumentDownload
     */
    protected $download;

    /**
     * PrivyUser constructor.
     *
     * @param $privyDocument
     */
    public function __construct($privyDocument = null)
    {
        if (is_object($privyDocument)) {
            $this->token = $privyDocument->docToken;
            $this->url = $privyDocument->urlDocument;

            $this->status = $privyDocument->documentStatus ?? null;

            $this->recipients = array_map(function ($recipient) {
                return new PrivyDocumentRecipient($recipient);
            }, $privyDocument->recipients);

            if (isset($privyDocument->download)) {
                $this->download = new PrivyDocumentDownload($privyDocument->download);
            }
        }
    }

    /**
     * Get serial type
     *
     * @return string
     */
    public function getTypeSerial()
    {
        return static::TYPE_SERIAL;
    }

    /**
     * Get serial parallel
     *
     * @return string
     */
    public function getTypeParallel()
    {
        return static::TYPE_PARALLEL;
    }

    /**
     * Get completed status
     *
     * @return string
     */
    public function getStatusCompleted()
    {
        return static::STATUS_COMPLETED;
    }

    /**
     * Get in progress status
     *
     * @return string
     */
    public function getStatusInProgress()
    {
        return static::STATUS_IN_PROGRESS;
    }

    /**
     * Get the digital signature document's status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the digital signature document's download
     *
     * @return PrivyDocumentDownload
     */
    public function getDownload()
    {
        return $this->download;
    }
}
