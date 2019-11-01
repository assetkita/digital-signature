<?php

namespace Assetku\DigitalSignature\Users\Privy;

class PrivyUserReject
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $reason;

    /**
     * @var PrivyUserRejectHandler[]
     */
    protected $handlers;

    /**
     * PrivyUserReject constructor.
     *
     * @param $privyUserReject
     */
    public function __construct($privyUserReject)
    {
        if (is_object($privyUserReject)) {
            $this->code = $privyUserReject->code;
            $this->reason = $privyUserReject->reason;

            if (isset($privyUserReject->handlers)) {
                $this->handlers = array_map(function ($handler) {
                    return new PrivyUserRejectHandler($handler);
                }, $privyUserReject->handlers);
            }
        }
    }

    /**
     * Get the digital signature user's reject code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the digital signature user's reject reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Get the digital signature user's reject handlers
     *
     * @return PrivyUserRejectHandler[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }
}
