<?php

namespace Assetku\DigitalSignature\Documents\Privy;

use Assetku\DigitalSignature\Documents\Document;
use Assetku\DigitalSignature\Documents\DocumentRecipients\Privy\PrivyDocumentRecipient;

class PrivyDocument extends Document
{
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
    public function __construct($privyDocument)
    {
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
