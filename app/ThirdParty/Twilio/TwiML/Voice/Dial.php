<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Dial extends TwiML
{
    public function __construct($number = null, $attributes = [])
    {
        parent::__construct('Dial', $number, $attributes);
    }

    public function client($identity = null, $attributes = []): Client
    {
        return $this->nest(new Client($identity, $attributes));
    }

    public function conference($name, $attributes = []): Conference
    {
        return $this->nest(new Conference($name, $attributes));
    }

    public function number($phoneNumber, $attributes = []): Number
    {
        return $this->nest(new Number($phoneNumber, $attributes));
    }

    public function queue($name, $attributes = []): Queue
    {
        return $this->nest(new Queue($name, $attributes));
    }

    public function sim($simSid): Sim
    {
        return $this->nest(new Sim($simSid));
    }

    public function sip($sipUrl, $attributes = []): Sip
    {
        return $this->nest(new Sip($sipUrl, $attributes));
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

    public function setHangupOnStar($hangupOnStar): self
    {
        return $this->setAttribute('hangupOnStar', $hangupOnStar);
    }

    public function setTimeLimit($timeLimit): self
    {
        return $this->setAttribute('timeLimit', $timeLimit);
    }

    public function setCallerId($callerId): self
    {
        return $this->setAttribute('callerId', $callerId);
    }

    public function setRecord($record): self
    {
        return $this->setAttribute('record', $record);
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

    public function setAnswerOnBridge($answerOnBridge): self
    {
        return $this->setAttribute('answerOnBridge', $answerOnBridge);
    }

    public function setRingTone($ringTone): self
    {
        return $this->setAttribute('ringTone', $ringTone);
    }

    public function setRecordingTrack($recordingTrack): self
    {
        return $this->setAttribute('recordingTrack', $recordingTrack);
    }

    public function setSequential($sequential): self
    {
        return $this->setAttribute('sequential', $sequential);
    }
}