<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Conference extends TwiML
{
    public function __construct($name, $attributes = [])
    {
        parent::__construct('Conference', $name, $attributes);
    }

    public function setMuted($muted): self
    {
        return $this->setAttribute('muted', $muted);
    }

    public function setBeep($beep): self
    {
        return $this->setAttribute('beep', $beep);
    }

    public function setStartConferenceOnEnter($startConferenceOnEnter): self
    {
        return $this->setAttribute('startConferenceOnEnter', $startConferenceOnEnter);
    }

    public function setEndConferenceOnExit($endConferenceOnExit): self
    {
        return $this->setAttribute('endConferenceOnExit', $endConferenceOnExit);
    }

    public function setWaitUrl($waitUrl): self
    {
        return $this->setAttribute('waitUrl', $waitUrl);
    }

    public function setWaitMethod($waitMethod): self
    {
        return $this->setAttribute('waitMethod', $waitMethod);
    }

    public function setMaxParticipants($maxParticipants): self
    {
        return $this->setAttribute('maxParticipants', $maxParticipants);
    }

    public function setRecord($record): self
    {
        return $this->setAttribute('record', $record);
    }

    public function setRegion($region): self
    {
        return $this->setAttribute('region', $region);
    }

    public function setCoach($coach): self
    {
        return $this->setAttribute('coach', $coach);
    }

    public function setTrim($trim): self
    {
        return $this->setAttribute('trim', $trim);
    }

    public function setStatusCallbackEvent($statusCallbackEvent): self
    {
        return $this->setAttribute('statusCallbackEvent', $statusCallbackEvent);
    }

    public function setStatusCallback($statusCallback): self
    {
        return $this->setAttribute('statusCallback', $statusCallback);
    }

    public function setStatusCallbackMethod($statusCallbackMethod): self
    {
        return $this->setAttribute('statusCallbackMethod', $statusCallbackMethod);
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

    public function setEventCallbackUrl($eventCallbackUrl): self
    {
        return $this->setAttribute('eventCallbackUrl', $eventCallbackUrl);
    }

    public function setJitterBufferSize($jitterBufferSize): self
    {
        return $this->setAttribute('jitterBufferSize', $jitterBufferSize);
    }

    public function setParticipantLabel($participantLabel): self
    {
        return $this->setAttribute('participantLabel', $participantLabel);
    }
}