<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Prompt extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Prompt', null, $attributes);
    }

    public function say($message, $attributes = []): Say
    {
        return $this->nest(new Say($message, $attributes));
    }

    public function play($url = null, $attributes = []): Play
    {
        return $this->nest(new Play($url, $attributes));
    }

    public function pause($attributes = []): Pause
    {
        return $this->nest(new Pause($attributes));
    }

    public function setFor_($for_): self
    {
        return $this->setAttribute('for_', $for_);
    }

    public function setErrorType($errorType): self
    {
        return $this->setAttribute('errorType', $errorType);
    }

    public function setCardType($cardType): self
    {
        return $this->setAttribute('cardType', $cardType);
    }

    public function setAttempt($attempt): self
    {
        return $this->setAttribute('attempt', $attempt);
    }
}