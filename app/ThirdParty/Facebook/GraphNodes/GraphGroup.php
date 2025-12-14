<?php

namespace Facebook\GraphNodes;

use DateTime;

class GraphGroup extends GraphNode
{
    protected static $graphObjectMap = ['cover' => '\Facebook\GraphNodes\GraphCoverPhoto', 'venue' => '\Facebook\GraphNodes\GraphLocation',];

    public function getId()
    {
        return $this->getField('id');
    }

    public function getCover()
    {
        return $this->getField('cover');
    }

    public function getDescription()
    {
        return $this->getField('description');
    }

    public function getEmail()
    {
        return $this->getField('email');
    }

    public function getIcon()
    {
        return $this->getField('icon');
    }

    public function getLink()
    {
        return $this->getField('link');
    }

    public function getName()
    {
        return $this->getField('name');
    }

    public function getMemberRequestCount()
    {
        return $this->getField('member_request_count');
    }

    public function getOwner()
    {
        return $this->getField('owner');
    }

    public function getParent()
    {
        return $this->getField('parent');
    }

    public function getPrivacy()
    {
        return $this->getField('privacy');
    }

    public function getUpdatedTime()
    {
        return $this->getField('updated_time');
    }

    public function getVenue()
    {
        return $this->getField('venue');
    }
}