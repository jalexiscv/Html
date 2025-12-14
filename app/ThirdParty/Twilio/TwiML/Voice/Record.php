<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Record extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Record', null, $attributes);
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

    public function setFinishOnKey($finishOnKey): self
    {
        return $this->setAttribute('finishOnKey', $finishOnKey);
    }

    public function setMaxLength($maxLength): self
    {
        return $this->setAttribute('maxLength', $maxLength);
    }

    public function setPlayBeep($playBeep): self
    {
        return $this->setAttribute('playBeep', $playBeep);
    }

    public function setTrim($trim): self
    {
        return $this->setAttribute('trim', $trim);
    }

    public function setRecordingStatusCallback($recordingStatusCallback): self
    {
        return $this->setAttribute('recordingStatusCallback', $recordingStatusCallback);
    }

    public function setRecordingStatusCallbackMethod($recordingStatusCallbackMethod): self
    {
        return $this->setAttribute('recordingStatusCallbackMethod', $recordingStatusCallbackMethod);
    }

    public function setRecordingStatusCallbackEvent($recordingStatusCallbackEvent): self
    {
        return $this->setAttribute('recordingStatusCallbackEvent', $recordingStatusCallbackEvent);
    }

    public function setTranscribe($transcribe): self
    {
        return $this->setAttribute('transcribe', $transcribe);
    }

    public function setTranscribeCallback($transcribeCallback): self
    {
        return $this->setAttribute('transcribeCallback', $transcribeCallback);
    }
}