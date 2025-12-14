<?php

namespace SendGrid\Mail;

use JsonSerializable;

class BccSettings implements JsonSerializable
{
    private $enable;
    private $email;

    public function __construct($enable = null, $email = null)
    {
        if (isset($enable)) {
            $this->setEnable($enable);
        }
        if (isset($email)) {
            $this->setEmail($email);
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

    public function setEmail($email)
    {
        if (!is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new TypeException('$email must valid and be of type string.');
        }
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function jsonSerialize()
    {
        return array_filter(['enable' => $this->getEnable(), 'email' => $this->getEmail()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
