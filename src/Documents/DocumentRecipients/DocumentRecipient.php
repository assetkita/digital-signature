<?php

namespace Assetku\DigitalSignature\Documents\DocumentRecipients;

abstract class DocumentRecipient
{
    /**
     * @var string
     */
    const ROLE_SIGNER = 'Signer';

    /**
     * @var string
     */
    const ROLE_REVIEWER = 'Reviewer';

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
        return $this->role === static::ROLE_SIGNER;
    }

    /**
     * Determine whether the document recipient's role is reviewer
     *
     * @return string
     */
    public function isRoleReviewer()
    {
        return $this->role === static::ROLE_REVIEWER;
    }

    /**
     * Determine whether the document recipient's status is completed
     *
     * @return string
     */
    public function isStatusCompleted()
    {
        return $this->status === static::STATUS_COMPLETED;
    }

    /**
     * Determine whether the document recipient's status is in progress
     *
     * @return string
     */
    public function isStatusInProgress()
    {
        return $this->status === static::STATUS_IN_PROGRESS;
    }

    /**
     * Get signer role
     *
     * @return string
     */
    public function getRoleSigner()
    {
        return static::ROLE_SIGNER;
    }

    /**
     * Get reviewer role
     *
     * @return string
     */
    public function getRoleReviewer()
    {
        return static::ROLE_REVIEWER;
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
}
