<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Subject implements JsonSerializable
{
    private $subject;

    public function __construct($subject = null)
    {
        if (isset($subject)) {
            $this->setSubject($subject);
        }
    }

    public function jsonSerialize(): mixed
    {
        return $this->getSubject();
    }

    public function getSubject()
    {
        return mb_convert_encoding($this->subject, 'UTF-8', 'UTF-8');
    }

    public function setSubject($subject)
    {
        if (!is_string($subject)) {
            throw new TypeException('$subject must be of type string.');
        }
        $this->subject = $subject;
    }
}
