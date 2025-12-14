<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlLang extends TwiML
{
    public function __construct($words, $attributes = [])
    {
        parent::__construct('lang', $words, $attributes);
    }

    public function setXmlLang($xmlLang): self
    {
        return $this->setAttribute('xml:Lang', $xmlLang);
    }
}