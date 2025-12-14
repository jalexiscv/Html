<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ParticipantOptions
{
    public static function update(bool $muted = Values::NONE, bool $hold = Values::NONE, string $holdUrl = Values::NONE, string $holdMethod = Values::NONE, string $announceUrl = Values::NONE, string $announceMethod = Values::NONE, string $waitUrl = Values::NONE, string $waitMethod = Values::NONE, bool $beepOnExit = Values::NONE, bool $endConferenceOnExit = Values::NONE, bool $coaching = Values::NONE, string $callSidToCoach = Values::NONE): UpdateParticipantOptions
    {
        return new UpdateParticipantOptions($muted, $hold, $holdUrl, $holdMethod, $announceUrl, $announceMethod, $waitUrl, $waitMethod, $beepOnExit, $endConferenceOnExit, $coaching, $callSidToCoach);
    }

    public static function create(string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, string $label = Values::NONE, int $timeout = Values::NONE, bool $record = Values::NONE, bool $muted = Values::NONE, string $beep = Values::NONE, bool $startConferenceOnEnter = Values::NONE, bool $endConferenceOnExit = Values::NONE, string $waitUrl = Values::NONE, string $waitMethod = Values::NONE, bool $earlyMedia = Values::NONE, int $maxParticipants = Values::NONE, string $conferenceRecord = Values::NONE, string $conferenceTrim = Values::NONE, string $conferenceStatusCallback = Values::NONE, string $conferenceStatusCallbackMethod = Values::NONE, array $conferenceStatusCallbackEvent = Values::ARRAY_NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, string $region = Values::NONE, string $conferenceRecordingStatusCallback = Values::NONE, string $conferenceRecordingStatusCallbackMethod = Values::NONE, array $recordingStatusCallbackEvent = Values::ARRAY_NONE, array $conferenceRecordingStatusCallbackEvent = Values::ARRAY_NONE, bool $coaching = Values::NONE, string $callSidToCoach = Values::NONE, string $jitterBufferSize = Values::NONE, string $byoc = Values::NONE, string $callerId = Values::NONE, string $callReason = Values::NONE, string $recordingTrack = Values::NONE): CreateParticipantOptions
    {
        return new CreateParticipantOptions($statusCallback, $statusCallbackMethod, $statusCallbackEvent, $label, $timeout, $record, $muted, $beep, $startConferenceOnEnter, $endConferenceOnExit, $waitUrl, $waitMethod, $earlyMedia, $maxParticipants, $conferenceRecord, $conferenceTrim, $conferenceStatusCallback, $conferenceStatusCallbackMethod, $conferenceStatusCallbackEvent, $recordingChannels, $recordingStatusCallback, $recordingStatusCallbackMethod, $sipAuthUsername, $sipAuthPassword, $region, $conferenceRecordingStatusCallback, $conferenceRecordingStatusCallbackMethod, $recordingStatusCallbackEvent, $conferenceRecordingStatusCallbackEvent, $coaching, $callSidToCoach, $jitterBufferSize, $byoc, $callerId, $callReason, $recordingTrack);
    }

    public static function read(bool $muted = Values::NONE, bool $hold = Values::NONE, bool $coaching = Values::NONE): ReadParticipantOptions
    {
        return new ReadParticipantOptions($muted, $hold, $coaching);
    }
}

class UpdateParticipantOptions extends Options
{
    public function __construct(bool $muted = Values::NONE, bool $hold = Values::NONE, string $holdUrl = Values::NONE, string $holdMethod = Values::NONE, string $announceUrl = Values::NONE, string $announceMethod = Values::NONE, string $waitUrl = Values::NONE, string $waitMethod = Values::NONE, bool $beepOnExit = Values::NONE, bool $endConferenceOnExit = Values::NONE, bool $coaching = Values::NONE, string $callSidToCoach = Values::NONE)
    {
        $this->options['muted'] = $muted;
        $this->options['hold'] = $hold;
        $this->options['holdUrl'] = $holdUrl;
        $this->options['holdMethod'] = $holdMethod;
        $this->options['announceUrl'] = $announceUrl;
        $this->options['announceMethod'] = $announceMethod;
        $this->options['waitUrl'] = $waitUrl;
        $this->options['waitMethod'] = $waitMethod;
        $this->options['beepOnExit'] = $beepOnExit;
        $this->options['endConferenceOnExit'] = $endConferenceOnExit;
        $this->options['coaching'] = $coaching;
        $this->options['callSidToCoach'] = $callSidToCoach;
    }

    public function setMuted(bool $muted): self
    {
        $this->options['muted'] = $muted;
        return $this;
    }

    public function setHold(bool $hold): self
    {
        $this->options['hold'] = $hold;
        return $this;
    }

    public function setHoldUrl(string $holdUrl): self
    {
        $this->options['holdUrl'] = $holdUrl;
        return $this;
    }

    public function setHoldMethod(string $holdMethod): self
    {
        $this->options['holdMethod'] = $holdMethod;
        return $this;
    }

    public function setAnnounceUrl(string $announceUrl): self
    {
        $this->options['announceUrl'] = $announceUrl;
        return $this;
    }

    public function setAnnounceMethod(string $announceMethod): self
    {
        $this->options['announceMethod'] = $announceMethod;
        return $this;
    }

    public function setWaitUrl(string $waitUrl): self
    {
        $this->options['waitUrl'] = $waitUrl;
        return $this;
    }

    public function setWaitMethod(string $waitMethod): self
    {
        $this->options['waitMethod'] = $waitMethod;
        return $this;
    }

    public function setBeepOnExit(bool $beepOnExit): self
    {
        $this->options['beepOnExit'] = $beepOnExit;
        return $this;
    }

    public function setEndConferenceOnExit(bool $endConferenceOnExit): self
    {
        $this->options['endConferenceOnExit'] = $endConferenceOnExit;
        return $this;
    }

    public function setCoaching(bool $coaching): self
    {
        $this->options['coaching'] = $coaching;
        return $this;
    }

    public function setCallSidToCoach(string $callSidToCoach): self
    {
        $this->options['callSidToCoach'] = $callSidToCoach;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateParticipantOptions ' . $options . ']';
    }
}

class CreateParticipantOptions extends Options
{
    public function __construct(string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, string $label = Values::NONE, int $timeout = Values::NONE, bool $record = Values::NONE, bool $muted = Values::NONE, string $beep = Values::NONE, bool $startConferenceOnEnter = Values::NONE, bool $endConferenceOnExit = Values::NONE, string $waitUrl = Values::NONE, string $waitMethod = Values::NONE, bool $earlyMedia = Values::NONE, int $maxParticipants = Values::NONE, string $conferenceRecord = Values::NONE, string $conferenceTrim = Values::NONE, string $conferenceStatusCallback = Values::NONE, string $conferenceStatusCallbackMethod = Values::NONE, array $conferenceStatusCallbackEvent = Values::ARRAY_NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, string $region = Values::NONE, string $conferenceRecordingStatusCallback = Values::NONE, string $conferenceRecordingStatusCallbackMethod = Values::NONE, array $recordingStatusCallbackEvent = Values::ARRAY_NONE, array $conferenceRecordingStatusCallbackEvent = Values::ARRAY_NONE, bool $coaching = Values::NONE, string $callSidToCoach = Values::NONE, string $jitterBufferSize = Values::NONE, string $byoc = Values::NONE, string $callerId = Values::NONE, string $callReason = Values::NONE, string $recordingTrack = Values::NONE)
    {
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['statusCallbackEvent'] = $statusCallbackEvent;
        $this->options['label'] = $label;
        $this->options['timeout'] = $timeout;
        $this->options['record'] = $record;
        $this->options['muted'] = $muted;
        $this->options['beep'] = $beep;
        $this->options['startConferenceOnEnter'] = $startConferenceOnEnter;
        $this->options['endConferenceOnExit'] = $endConferenceOnExit;
        $this->options['waitUrl'] = $waitUrl;
        $this->options['waitMethod'] = $waitMethod;
        $this->options['earlyMedia'] = $earlyMedia;
        $this->options['maxParticipants'] = $maxParticipants;
        $this->options['conferenceRecord'] = $conferenceRecord;
        $this->options['conferenceTrim'] = $conferenceTrim;
        $this->options['conferenceStatusCallback'] = $conferenceStatusCallback;
        $this->options['conferenceStatusCallbackMethod'] = $conferenceStatusCallbackMethod;
        $this->options['conferenceStatusCallbackEvent'] = $conferenceStatusCallbackEvent;
        $this->options['recordingChannels'] = $recordingChannels;
        $this->options['recordingStatusCallback'] = $recordingStatusCallback;
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        $this->options['region'] = $region;
        $this->options['conferenceRecordingStatusCallback'] = $conferenceRecordingStatusCallback;
        $this->options['conferenceRecordingStatusCallbackMethod'] = $conferenceRecordingStatusCallbackMethod;
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
        $this->options['conferenceRecordingStatusCallbackEvent'] = $conferenceRecordingStatusCallbackEvent;
        $this->options['coaching'] = $coaching;
        $this->options['callSidToCoach'] = $callSidToCoach;
        $this->options['jitterBufferSize'] = $jitterBufferSize;
        $this->options['byoc'] = $byoc;
        $this->options['callerId'] = $callerId;
        $this->options['callReason'] = $callReason;
        $this->options['recordingTrack'] = $recordingTrack;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function setStatusCallbackEvent(array $statusCallbackEvent): self
    {
        $this->options['statusCallbackEvent'] = $statusCallbackEvent;
        return $this;
    }

    public function setLabel(string $label): self
    {
        $this->options['label'] = $label;
        return $this;
    }

    public function setTimeout(int $timeout): self
    {
        $this->options['timeout'] = $timeout;
        return $this;
    }

    public function setRecord(bool $record): self
    {
        $this->options['record'] = $record;
        return $this;
    }

    public function setMuted(bool $muted): self
    {
        $this->options['muted'] = $muted;
        return $this;
    }

    public function setBeep(string $beep): self
    {
        $this->options['beep'] = $beep;
        return $this;
    }

    public function setStartConferenceOnEnter(bool $startConferenceOnEnter): self
    {
        $this->options['startConferenceOnEnter'] = $startConferenceOnEnter;
        return $this;
    }

    public function setEndConferenceOnExit(bool $endConferenceOnExit): self
    {
        $this->options['endConferenceOnExit'] = $endConferenceOnExit;
        return $this;
    }

    public function setWaitUrl(string $waitUrl): self
    {
        $this->options['waitUrl'] = $waitUrl;
        return $this;
    }

    public function setWaitMethod(string $waitMethod): self
    {
        $this->options['waitMethod'] = $waitMethod;
        return $this;
    }

    public function setEarlyMedia(bool $earlyMedia): self
    {
        $this->options['earlyMedia'] = $earlyMedia;
        return $this;
    }

    public function setMaxParticipants(int $maxParticipants): self
    {
        $this->options['maxParticipants'] = $maxParticipants;
        return $this;
    }

    public function setConferenceRecord(string $conferenceRecord): self
    {
        $this->options['conferenceRecord'] = $conferenceRecord;
        return $this;
    }

    public function setConferenceTrim(string $conferenceTrim): self
    {
        $this->options['conferenceTrim'] = $conferenceTrim;
        return $this;
    }

    public function setConferenceStatusCallback(string $conferenceStatusCallback): self
    {
        $this->options['conferenceStatusCallback'] = $conferenceStatusCallback;
        return $this;
    }

    public function setConferenceStatusCallbackMethod(string $conferenceStatusCallbackMethod): self
    {
        $this->options['conferenceStatusCallbackMethod'] = $conferenceStatusCallbackMethod;
        return $this;
    }

    public function setConferenceStatusCallbackEvent(array $conferenceStatusCallbackEvent): self
    {
        $this->options['conferenceStatusCallbackEvent'] = $conferenceStatusCallbackEvent;
        return $this;
    }

    public function setRecordingChannels(string $recordingChannels): self
    {
        $this->options['recordingChannels'] = $recordingChannels;
        return $this;
    }

    public function setRecordingStatusCallback(string $recordingStatusCallback): self
    {
        $this->options['recordingStatusCallback'] = $recordingStatusCallback;
        return $this;
    }

    public function setRecordingStatusCallbackMethod(string $recordingStatusCallbackMethod): self
    {
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        return $this;
    }

    public function setSipAuthUsername(string $sipAuthUsername): self
    {
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        return $this;
    }

    public function setSipAuthPassword(string $sipAuthPassword): self
    {
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        return $this;
    }

    public function setRegion(string $region): self
    {
        $this->options['region'] = $region;
        return $this;
    }

    public function setConferenceRecordingStatusCallback(string $conferenceRecordingStatusCallback): self
    {
        $this->options['conferenceRecordingStatusCallback'] = $conferenceRecordingStatusCallback;
        return $this;
    }

    public function setConferenceRecordingStatusCallbackMethod(string $conferenceRecordingStatusCallbackMethod): self
    {
        $this->options['conferenceRecordingStatusCallbackMethod'] = $conferenceRecordingStatusCallbackMethod;
        return $this;
    }

    public function setRecordingStatusCallbackEvent(array $recordingStatusCallbackEvent): self
    {
        $this->options['recordingStatusCallbackEvent'] = $recordingStatusCallbackEvent;
        return $this;
    }

    public function setConferenceRecordingStatusCallbackEvent(array $conferenceRecordingStatusCallbackEvent): self
    {
        $this->options['conferenceRecordingStatusCallbackEvent'] = $conferenceRecordingStatusCallbackEvent;
        return $this;
    }

    public function setCoaching(bool $coaching): self
    {
        $this->options['coaching'] = $coaching;
        return $this;
    }

    public function setCallSidToCoach(string $callSidToCoach): self
    {
        $this->options['callSidToCoach'] = $callSidToCoach;
        return $this;
    }

    public function setJitterBufferSize(string $jitterBufferSize): self
    {
        $this->options['jitterBufferSize'] = $jitterBufferSize;
        return $this;
    }

    public function setByoc(string $byoc): self
    {
        $this->options['byoc'] = $byoc;
        return $this;
    }

    public function setCallerId(string $callerId): self
    {
        $this->options['callerId'] = $callerId;
        return $this;
    }

    public function setCallReason(string $callReason): self
    {
        $this->options['callReason'] = $callReason;
        return $this;
    }

    public function setRecordingTrack(string $recordingTrack): self
    {
        $this->options['recordingTrack'] = $recordingTrack;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateParticipantOptions ' . $options . ']';
    }
}

class ReadParticipantOptions extends Options
{
    public function __construct(bool $muted = Values::NONE, bool $hold = Values::NONE, bool $coaching = Values::NONE)
    {
        $this->options['muted'] = $muted;
        $this->options['hold'] = $hold;
        $this->options['coaching'] = $coaching;
    }

    public function setMuted(bool $muted): self
    {
        $this->options['muted'] = $muted;
        return $this;
    }

    public function setHold(bool $hold): self
    {
        $this->options['hold'] = $hold;
        return $this;
    }

    public function setCoaching(bool $coaching): self
    {
        $this->options['coaching'] = $coaching;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadParticipantOptions ' . $options . ']';
    }
}