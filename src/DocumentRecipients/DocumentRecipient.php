<?php

namespace Assetku\DigitalSignature\DocumentRecipients;

abstract class DocumentRecipient
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $role;

    /**
     * @var string
     */
    protected $status;

    /**
     * Get signer role
     *
     * @return string
     */
    abstract public function getRoleSigner();

    /**
     * Get reviewer role
     *
     * @return string
     */
    abstract public function getRoleReviewer();

    /**
     * Get completed status
     *
     * @return string
     */
    abstract public function getStatusCompleted();

    /**
     * Get in progress status
     *
     * @return string
     */
    abstract public function getStatusInProgress();

    /**
     * Get the digital signature document recipient's id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the digital signature document recipient's role
     *
     * @return string
     */
    public function getRecipientRole()
    {
        return $this->role;
    }

    /**
     * Get the digital signature document recipient's status
     *
     * @return string
     */
    public function getRecipientStatus()
    {
        return $this->status;
    }

    /**
     * Determine whether the document recipient's role is signer
     *
     * @return string
     */
    public function isRoleSigner()
    {
        return $this->role === $this->getRoleSigner();
    }

    /**
     * Determine whether the document recipient's role is reviewer
     *
     * @return string
     */
    public function isRoleReviewer()
    {
        return $this->role === $this->getRoleReviewer();
    }

    /**
     * Determine whether the document recipient's status is completed
     *
     * @return string
     */
    public function isStatusCompleted()
    {
        return $this->status === $this->getStatusCompleted();
    }

    /**
     * Determine whether the document recipient's status is in progress
     *
     * @return string
     */
    public function isStatusInProgress()
    {
        return $this->status === $this->getStatusInProgress();
    }
}
