<?php

namespace SendGrid;

use JsonSerializable;

class RecipientForm
{
    private $html;

    public function __construct($url)
    {
        $html = '<form action="' . $url . '" method="post">
    First Name: <input type="text" name="first-name"><br>
    Last Name: <input type="text" name="last-name"><br>
    E-mail: <input type="text" name="email"><br>
    <input type="submit">
</form>';
        $this->html = $html;
    }

    public function __toString()
    {
        return $this->html;
    }
}

class Recipient implements JsonSerializable
{
    private $firstName;
    private $lastName;
    private $email;

    public function __construct($firstName, $lastName, $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function jsonSerialize()
    {
        return array_filter(['email' => $this->getEmail(), 'first_name' => $this->getFirstName(), 'last_name' => $this->getLastName()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
