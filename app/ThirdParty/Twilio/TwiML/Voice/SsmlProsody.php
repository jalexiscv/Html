<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlProsody extends TwiML
{
    public function __construct($words, $attributes = [])
    {
        parent::__construct('prosody', $words, $attributes);
    }

    public function setVolume($volume): self
    {
        return $this->setAttribute('volume', $volume);
    }

    public function setRate($rate): self
    {
        return $this->setAttribute('rate', $rate);
    }

    public function setPitch($pitch): self
    {
        return $this->setAttribute('pitch', $pitch);
    }
}