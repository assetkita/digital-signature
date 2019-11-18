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
    protected $expiredAt;

    /**
     * PrivyDocumentDownload constructor.
     *
     * @param $privyDocumentDownload
     */
    public function __construct($privyDocumentDownload = null)
    {
        if (is_object($privyDocumentDownload)) {
            $this->url = $privyDocumentDownload->url;
            $this->expiredAt = $privyDocumentDownload->expiredAt;
        }
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
     * Get the digital signature document's download expired at
     *
     * @return string
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }
}
