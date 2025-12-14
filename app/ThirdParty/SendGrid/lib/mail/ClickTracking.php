<?php

namespace SendGrid\Mail;

use JsonSerializable;

class ClickTracking implements JsonSerializable
{
    private $enable;
    private $enable_text;

    public function __construct($enable = null, $enable_text = null)
    {
        if (isset($enable)) {
            $this->setEnable($enable);
        }
        if (isset($enable_text)) {
            $this->setEnableText($enable_text);
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

    public function setEnableText($enable_text)
    {
        if (!is_bool($enable_text)) {
            throw new TypeException('$enable_text must be of type bool');
        }
        $this->enable_text = $enable_text;
    }

    public function getEnableText()
    {
        return $this->enable_text;
    }

    public function jsonSerialize()
    {
        return array_filter(['enable' => $this->getEnable(), 'enable_text' => $this->getEnableText()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
