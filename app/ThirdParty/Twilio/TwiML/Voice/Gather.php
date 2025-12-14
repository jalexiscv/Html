<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Gather extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Gather', null, $attributes);
    }

    public function say($message, $attributes = []): Say
    {
        return $this->nest(new Say($message, $attributes));
    }

    public function pause($attributes = []): Pause
    {
        return $this->nest(new Pause($attributes));
    }

    public function play($url = null, $attributes = []): Play
    {
        return $this->nest(new Play($url, $attributes));
    }

    public function setInput($input): self
    {
        return $this->setAttribute('input', $input);
    }

    public function setAction($action): self
    {
        return $this->setAttribute('action', $action);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }

    public function setTimeout($timeout): self
    {
        return $this->setAttribute('timeout', $timeout);
    }

    public function setSpeechTimeout($speechTimeout): self
    {
        return $this->setAttribute('speechTimeout', $speechTimeout);
    }

    public function setMaxSpeechTime($maxSpeechTime): self
    {
        return $this->setAttribute('maxSpeechTime', $maxSpeechTime);
    }

    public function setProfanityFilter($profanityFilter): self
    {
        return $this->setAttribute('profanityFilter', $profanityFilter);
    }

    public function setFinishOnKey($finishOnKey): self
    {
        return $this->setAttribute('finishOnKey', $finishOnKey);
    }

    public function setNumDigits($numDigits): self
    {
        return $this->setAttribute('numDigits', $numDigits);
    }

    public function setPartialResultCallback($partialResultCallback): self
    {
        return $this->setAttribute('partialResultCallback', $partialResultCallback);
    }

    public function setPartialResultCallbackMethod($partialResultCallbackMethod): self
    {
        return $this->setAttribute('partialResultCallbackMethod', $partialResultCallbackMethod);
    }

    public function setLanguage($language): self
    {
        return $this->setAttribute('language', $language);
    }

    public function setHints($hints): self
    {
        return $this->setAttribute('hints', $hints);
    }

    public function setBargeIn($bargeIn): self
    {
        return $this->setAttribute('bargeIn', $bargeIn);
    }

    public function setDebug($debug): self
    {
        return $this->setAttribute('debug', $debug);
    }

    public function setActionOnEmptyResult($actionOnEmptyResult): self
    {
        return $this->setAttribute('actionOnEmptyResult', $actionOnEmptyResult);
    }

    public function setSpeechModel($speechModel): self
    {
        return $this->setAttribute('speechModel', $speechModel);
    }

    public function setEnhanced($enhanced): self
    {
        return $this->setAttribute('enhanced', $enhanced);
    }
}