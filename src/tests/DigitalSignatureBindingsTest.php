<?php

namespace Assetku\DigitalSignature\tests;

use Assetku\DigitalSignature\Documents\DocumentRecipients\Privy\PrivyDocumentRecipient;
use Assetku\DigitalSignature\Documents\Privy\PrivyDocument;
use Assetku\DigitalSignature\Users\Privy\PrivyUser;

class DigitalSignatureBindingsTest extends TestCase
{
    /**
     * Test for binded user is appropriate.
     *
     */
    public function testBindedUserIsAppropriate()
    {
        if (config('digital-signature.default') === 'privy') {
            $this->assertTrue(\DigitalSignature::getUser() === PrivyUser::class);
        }
    }

    /**
     * Test for binded document is appropriate.
     *
     */
    public function testBindedDocumentIsAppropriate()
    {
        if (config('digital-signature.default') === 'privy') {
            $this->assertTrue(\DigitalSignature::getDocument() === PrivyDocument::class);
        }
    }

    /**
     * Test for binded document recipient is appropriate.
     *
     */
    public function testBindedDocumentRecipientIsAppropriate()
    {
        if (config('digital-signature.default') === 'privy') {
            $this->assertTrue(\DigitalSignature::getDocumentRecipient() === PrivyDocumentRecipient::class);
        }
    }
}
