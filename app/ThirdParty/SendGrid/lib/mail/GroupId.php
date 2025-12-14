<?php

namespace SendGrid\Mail;

use JsonSerializable;

class GroupId implements JsonSerializable
{
    private $group_id;

    public function __construct($group_id = null)
    {
        if (isset($group_id)) {
            $this->setGroupId($group_id);
        }
    }

    public function setGroupId($group_id)
    {
        if (!is_int($group_id)) {
            throw new TypeException('$group_id must be of type int.');
        }
        $this->group_id = $group_id;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function jsonSerialize()
    {
        return $this->getGroupId();
    }
}
