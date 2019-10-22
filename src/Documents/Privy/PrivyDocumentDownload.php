<?php

namespace Assetku\DigitalSignature\Documents\Privy;

class PrivyDocumentDownload
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $expiresAt;

    /**
     * PrivyDocumentDownload constructor.
     *
     * @param $privyDocumentDownload
     */
    public function __construct($privyDocumentDownload)
    {
        $this->url = $privyDocumentDownload->url;
        $this->expiresAt = $privyDocumentDownload->expiresAt;
    }

    /**
     * Get the digital signature document's download url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the digital signature document's download expires at
     *
     * @return string
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
}
