<?php

namespace SendGrid\Mail;

use JsonSerializable;

class BypassListManagement implements JsonSerializable
{
    private $enable;

    public function __construct($enable = null)
    {
        if (isset($enable)) {
            $this->setEnable($enable);
        }
    }

    public function setEnable($enable)
    {
        if (!is_bool($enable)) {
            throw new TypeException('$enable must be of type bool.');
        }
        $this->enable = $enable;
    }

    public function getEnable()
    {
        return $this->enable;
    }

    public function jsonSerialize()
    {
        return array_filter(['enable' => $this->getEnable()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
