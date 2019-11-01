<?php

namespace Assetku\DigitalSignature\Users;

abstract class User
{
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
     * Get verified status
     *
     * @return string
     */
    abstract public function getStatusVerified();

    /**
     * Get waiting status
     *
     * @return string
     */
    abstract public function getStatusWaiting();

    /**
     * Get registered status
     *
     * @return string
     */
    abstract public function getStatusRegistered();

    /**
     * Get invalid status
     *
     * @return string
     */
    abstract public function getStatusInvalid();

    /**
     * Get rejected status
     *
     * @return string
     */
    abstract public function getStatusRejected();

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
        return $this->status === $this->getStatusVerified();
    }

    /**
     * Determine whether the user's status is waiting
     *
     * @return bool
     */
    public function isStatusWaiting()
    {
        return $this->status === $this->getStatusWaiting();
    }

    /**
     * Determine whether the user's status is registered
     *
     * @return bool
     */
    public function isStatusRegistered()
    {
        return $this->status === $this->getStatusRegistered();
    }

    /**
     * Determine whether the user's status is invalid
     *
     * @return bool
     */
    public function isStatusInvalid()
    {
        return $this->status === $this->getStatusInvalid();
    }

    /**
     * Determine whether the user's status is rejected
     *
     * @return bool
     */
    public function isStatusRejected()
    {
        return $this->status === $this->getStatusRejected();
    }
}
