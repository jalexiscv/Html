<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Footer implements JsonSerializable
{
    private $enable;
    private $text;
    private $html;

    public function __construct($enable = null, $text = null, $html = null)
    {
        if (isset($enable)) {
            $this->setEnable($enable);
        }
        if (isset($text)) {
            $this->setText($text);
        }
        if (isset($html)) {
            $this->setHtml($html);
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

    public function setText($text)
    {
        if (!is_string($text)) {
            throw new TypeException('$text must be of type string.');
        }
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setHtml($html)
    {
        if (!is_string($html)) {
            throw new TypeException('$html must be of type string.');
        }
        $this->html = $html;
    }

    public function getHtml()
    {
        return $this->html;
    }

    public function jsonSerialize()
    {
        return array_filter(['enable' => $this->getEnable(), 'text' => $this->getText(), 'html' => $this->getHtml()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
