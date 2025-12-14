<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlSub extends TwiML
{
    public function __construct($words, $attributes = [])
    {
        parent::__construct('sub', $words, $attributes);
    }

    public function setAlias($alias): self
    {
        return $this->setAttribute('alias', $alias);
    }
}