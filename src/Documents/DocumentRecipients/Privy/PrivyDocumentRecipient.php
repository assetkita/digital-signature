<?php

namespace Assetku\DigitalSignature\Documents\DocumentRecipients\Privy;

use Assetku\DigitalSignature\Documents\DocumentRecipients\DocumentRecipient;

class PrivyDocumentRecipient extends DocumentRecipient
{
    /**
     * @var string
     */
    protected $enterpriseToken;

    /**
     * PrivyDocumentRecipient constructor.
     *
     * @param $privyDocumentRecipient
     */
    public function __construct($privyDocumentRecipient)
    {
        $this->id = $privyDocumentRecipient->privyId;
        $this->role = $privyDocumentRecipient->type;
        $this->enterpriseToken = $privyDocumentRecipient->enterpriseToken ?? null;
        $this->status = $privyDocumentRecipient->signatoryStatus ?? null;
    }

    /**
     * Get the digital signature document recipient's enterprise token
     *
     * @return string
     */
    public function getEnterpriseToken()
    {
        return $this->enterpriseToken;
    }
}
