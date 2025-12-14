<?php

namespace Facebook\GraphNodes;
class GraphUser extends GraphNode
{
    protected static $graphObjectMap = ['hometown' => '\Facebook\GraphNodes\GraphPage', 'location' => '\Facebook\GraphNodes\GraphPage', 'significant_other' => '\Facebook\GraphNodes\GraphUser', 'picture' => '\Facebook\GraphNodes\GraphPicture',];

    public function getId()
    {
        return $this->getField('id');
    }

    public function getName()
    {
        return $this->getField('name');
    }

    public function getFirstName()
    {
        return $this->getField('first_name');
    }

    public function getMiddleName()
    {
        return $this->getField('middle_name');
    }

    public function getLastName()
    {
        return $this->getField('last_name');
    }

    public function getEmail()
    {
        return $this->getField('email');
    }

    public function getGender()
    {
        return $this->getField('gender');
    }

    public function getLink()
    {
        return $this->getField('link');
    }

    public function getBirthday()
    {
        return $this->getField('birthday');
    }

    public function getLocation()
    {
        return $this->getField('location');
    }

    public function getHometown()
    {
        return $this->getField('hometown');
    }

    public function getSignificantOther()
    {
        return $this->getField('significant_other');
    }

    public function getPicture()
    {
        return $this->getField('picture');
    }
}