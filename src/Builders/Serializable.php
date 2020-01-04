<?php

namespace Assetku\DigitalSignature\Builders;

interface Serializable
{
    /**
     * Serialize builder attributes to array
     *
     * @return array
     */
    public function serialize();
}
