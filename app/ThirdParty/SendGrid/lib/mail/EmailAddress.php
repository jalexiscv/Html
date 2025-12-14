<?php

namespace SendGrid\Mail;

use JsonSerializable;

class EmailAddress implements JsonSerializable
{
    private $name;
    private $email;
    private $substitutions;
    private $subject;

    public function __construct($emailAddress = null, $name = null, $substitutions = null, $subject = null)
    {
        if (isset($emailAddress)) {
            $this->setEmailAddress($emailAddress);
        }
        if (isset($name) && $name !== null) {
            $this->setName($name);
        }
        if (isset($substitutions)) {
            $this->setSubstitutions($substitutions);
        }
        if (isset($subject)) {
            $this->setSubject($subject);
        }
    }

    public function setEmailAddress($emailAddress)
    {
        if (!(is_string($emailAddress) && filter_var($emailAddress, FILTER_VALIDATE_EMAIL))) {
            throw new TypeException('$emailAddress must be valid and of type string.');
        }
        $this->email = $emailAddress;
    }

    public function getSubstitutions()
    {
        return $this->substitutions;
    }

    public function setSubstitutions($substitutions)
    {
        if (!is_array($substitutions)) {
            throw new TypeException('$substitutions must be an array.');
        }
        $this->substitutions = $substitutions;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        if (!is_string($subject)) {
            throw new TypeException('$subject must be of type string.');
        }
        if (!($subject instanceof Subject)) {
            $this->subject = new Subject($subject);
        } else {
            $this->subject = $subject;
        }
    }

    public function jsonSerialize(): mixed
    {
        return array_filter(['name' => $this->getName(), 'email' => $this->getEmail()], function ($value) {
            return $value !== null;
        }) ?: null;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (!is_string($name)) {
            throw new TypeException('$name must be of type string.');
        }
        if (false !== strpos($name, ',') || false !== strpos($name, ';')) {
            $name = stripslashes(html_entity_decode($name, ENT_QUOTES));
            $name = str_replace('"', '\\"', $name);
            $name = '"' . $name . '"';
        }
        $this->name = (!empty($name)) ? $name : null;
    }

    public function getEmail()
    {
        return $this->getEmailAddress();
    }

    public function getEmailAddress()
    {
        return $this->email;
    }
}
