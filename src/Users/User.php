<?php

namespace Assetku\DigitalSignature\Users;

abstract class User
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
    protected $id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $status;

    /**
     * Get the digital signature user's identification
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the digital signature user's email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the digital signature user's phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the digital signature user's token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the digital signature user's status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Determine whether the user's status is verified
     *
     * @return bool
     */
    public function isStatusVerified()
    {
        return $this->status === static::STATUS_VERIFIED;
    }

    /**
     * Determine whether the user's status is waiting
     *
     * @return bool
     */
    public function isStatusWaiting()
    {
        return $this->status === static::STATUS_WAITING;
    }

    /**
     * Determine whether the user's status is registered
     *
     * @return bool
     */
    public function isStatusRegistered()
    {
        return $this->status === static::STATUS_REGISTERED;
    }

    /**
     * Determine whether the user's status is invalid
     *
     * @return bool
     */
    public function isStatusInvalid()
    {
        return $this->status === static::STATUS_INVALID;
    }

    /**
     * Determine whether the user's status is rejected
     *
     * @return bool
     */
    public function isStatusRejected()
    {
        return $this->status === static::STATUS_REJECTED;
    }

    /**
     * Get verified status
     *
     * @return string
     */
    public function getStatusVerified()
    {
        return static::STATUS_VERIFIED;
    }

    /**
     * Get waiting status
     *
     * @return string
     */
    public function getStatusWaiting()
    {
        return static::STATUS_WAITING;
    }

    /**
     * Get registered status
     *
     * @return string
     */
    public function getStatusRegistered()
    {
        return static::STATUS_REGISTERED;
    }

    /**
     * Get invalid status
     *
     * @return string
     */
    public function getStatusInvalid()
    {
        return static::STATUS_INVALID;
    }

    /**
     * Get rejected status
     *
     * @return string
     */
    public function getStatusRejected()
    {
        return static::STATUS_REJECTED;
    }
}
