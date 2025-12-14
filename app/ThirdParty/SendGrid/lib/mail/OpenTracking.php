<?php

namespace SendGrid\Mail;

use JsonSerializable;

class OpenTracking implements JsonSerializable
{
    private $enable;
    private $substitution_tag;

    public function __construct($enable = null, $substitution_tag = null)
    {
        if (isset($enable)) {
            $this->setEnable($enable);
        }
        if (isset($substitution_tag)) {
            $this->setSubstitutionTag($substitution_tag);
        }
    }

    public function setEnable($enable)
    {
        if (!is_bool($enable)) {
            throw new TypeException('$enable must be of type bool');
        }
        $this->enable = $enable;
    }

    public function getEnable()
    {
        return $this->enable;
    }

    public function setSubstitutionTag($substitution_tag)
    {
        if (!is_string($substitution_tag)) {
            throw new TypeException('$substitution_tag must be of type string.');
        }
        $this->substitution_tag = $substitution_tag;
    }

    public function getSubstitutionTag()
    {
        return $this->substitution_tag;
    }

    public function jsonSerialize()
    {
        return array_filter(['enable' => $this->getEnable(), 'substitution_tag' => $this->getSubstitutionTag()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
