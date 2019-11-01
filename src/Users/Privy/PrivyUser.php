<?php

namespace Assetku\DigitalSignature\Users\Privy;

use Assetku\DigitalSignature\Users\User;

class PrivyUser extends User
{
    /**
     * @var string
     */
    const STATUS_VERIFIED = 'verified';

    /**
     * @var string
     */
    const STATUS_WAITING = 'waiting';

    /**
     * @var string
     */
    const STATUS_REGISTERED = 'registered';

    /**
     * @var string
     */
    const STATUS_INVALID = 'invalid';

    /**
     * @var string
     */
    const STATUS_REJECTED = 'rejected';

    /**
     * @var string
     */
    protected $processedAt;

    /**
     * @var PrivyUserIdentity
     */
    protected $identity;

    /**
     * @var PrivyUserReject
     */
    protected $reject;

    /**
     * PrivyUser constructor.
     *
     * @param $privyUser
     */
    public function __construct($privyUser)
    {
        $this->email = $privyUser->email;
        $this->phone = $privyUser->phone;
        $this->token = $privyUser->userToken;
        $this->status = $privyUser->status;

        $this->id = $privyUser->privyId ?? null;
        $this->processedAt = $privyUser->processedAt ?? null;

        if (isset($privyUser->identity)) {
            $this->identity = new PrivyUserIdentity($privyUser->identity);
        }

        if (isset($privyUser->reject)) {
            $this->reject = new PrivyUserReject($privyUser->reject);
        }
    }

    /**
     * Get the digital signature user's processed at
     *
     * @return string
     */
    public function getProcessedAt()
    {
        return $this->processedAt;
    }

    /**
     * Get the digital signature user's identity
     *
     * @return PrivyUserIdentity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Get the digital signature user's reject
     *
     * @return PrivyUserReject
     */
    public function getReject()
    {
        return $this->reject;
    }
}
