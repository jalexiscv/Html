<?php

namespace SendGrid\Mail;

use JsonSerializable;

class GroupsToDisplay implements JsonSerializable
{
    private $groups_to_display;

    public function __construct($groups_to_display = null)
    {
        if (isset($groups_to_display)) {
            $this->setGroupsToDisplay($groups_to_display);
        }
    }

    public function setGroupsToDisplay($groups_to_display)
    {
        if (!is_array($groups_to_display)) {
            throw new TypeException('$groups_to_display must be an array.');
        }
        if (is_array($groups_to_display)) {
            $this->groups_to_display = $groups_to_display;
        } else {
            $this->groups_to_display[] = $groups_to_display;
        }
    }

    public function getGroupsToDisplay()
    {
        return $this->groups_to_display;
    }

    public function jsonSerialize()
    {
        return $this->getGroupsToDisplay();
    }
}
