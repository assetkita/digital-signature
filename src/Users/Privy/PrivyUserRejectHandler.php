<?php

namespace Assetku\DigitalSignature\Users\Privy;

class PrivyUserRejectHandler
{
    /**
     * @var string
     */
    protected $category;

    /**
     * @var string
     */
    protected $handler;

    /**
     * @var array
     */
    protected $fileSupport;

    /**
     * PrivyUserRejectHandler constructor.
     *
     * @param $privyUserRejectHandler
     */
    public function __construct($privyUserRejectHandler)
    {
        if (is_object($privyUserRejectHandler)) {
            $this->category = $privyUserRejectHandler->category;
            $this->handler = $privyUserRejectHandler->handler;
            $this->fileSupport = $privyUserRejectHandler->file_support;
        }
    }

    /**
     * Get the digital signature user's reject handler category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get the digital signature user's reject handler handler
     *
     * @return string
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Get the digital signature user's reject handler file support
     *
     * @return array
     */
    public function getFileSupport()
    {
        return $this->fileSupport;
    }
}
