<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Task;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ReservationOptions
{
    public static function read(string $reservationStatus = Values::NONE): ReadReservationOptions
    {
        return new ReadReservationOptions($reservationStatus);
    }

    public static function update(string $reservationStatus = Values::NONE, string $workerActivitySid = Values::NONE, string $instruction = Values::NONE, string $dequeuePostWorkActivitySid = Values::NONE, string $dequeueFrom = Values::NONE, string $dequeueRecord = Values::NONE, int $dequeueTimeout = Values::NONE, string $dequeueTo = Values::NONE, string $dequeueStatusCallbackUrl = Values::NONE, string $callFrom = Values::NONE, string $callRecord = Values::NONE, int $callTimeout = Values::NONE, string $callTo = Values::NONE, string $callUrl = Values::NONE, string $callStatusCallbackUrl = Values::NONE, bool $callAccept = Values::NONE, string $redirectCallSid = Values::NONE, bool $redirectAccept = Values::NONE, string $redirectUrl = Values::NONE, string $to = Values::NONE, string $from = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, int $timeout = Values::NONE, bool $record = Values::NONE, bool $muted = Values::NONE, string $beep = Values::NONE, bool $startConferenceOnEnter = Values::NONE, bool $endConferenceOnExit = Values::NONE, string $waitUrl = Values::NONE, string $waitMethod = Values::NONE, bool $earlyMedia = Values::NONE, int $maxParticipants = Values::NONE, string $conferenceStatusCallback = Values::NONE, string $conferenceStatusCallbackMethod = Values::NONE, array $conferenceStatusCallbackEvent = Values::ARRAY_NONE, string $conferenceRecord = Values::NONE, string $conferenceTrim = Values::NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $conferenceRecordingStatusCallback = Values::NONE, string $conferenceRecordingStatusCallbackMethod = Values::NONE, string $region = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, array $dequeueStatusCallbackEvent = Values::ARRAY_NONE, string $postWorkActivitySid = Values::NONE, string $supervisorMode = Values::NONE, string $supervisor = Values::NONE, bool $endConferenceOnCustomerExit = Values::NONE, bool $beepOnCustomerEntrance = Values::NONE): UpdateReservationOptions
    {
        return new UpdateReservationOptions($reservationStatus, $workerActivitySid, $instruction, $dequeuePostWorkActivitySid, $dequeueFrom, $dequeueRecord, $dequeueTimeout, $dequeueTo, $dequeueStatusCallbackUrl, $callFrom, $callRecord, $callTimeout, $callTo, $callUrl, $callStatusCallbackUrl, $callAccept, $redirectCallSid, $redirectAccept, $redirectUrl, $to, $from, $statusCallback, $statusCallbackMethod, $statusCallbackEvent, $timeout, $record, $muted, $beep, $startConferenceOnEnter, $endConferenceOnExit, $waitUrl, $waitMethod, $earlyMedia, $maxParticipants, $conferenceStatusCallback, $conferenceStatusCallbackMethod, $conferenceStatusCallbackEvent, $conferenceRecord, $conferenceTrim, $recordingChannels, $recordingStatusCallback, $recordingStatusCallbackMethod, $conferenceRecordingStatusCallback, $conferenceRecordingStatusCallbackMethod, $region, $sipAuthUsername, $sipAuthPassword, $dequeueStatusCallbackEvent, $postWorkActivitySid, $supervisorMode, $supervisor, $endConferenceOnCustomerExit, $beepOnCustomerEntrance);
    }
}

class ReadReservationOptions extends Options
{
    public function __construct(string $reservationStatus = Values::NONE)
    {
        $this->options['reservationStatus'] = $reservationStatus;
    }

    public function setReservationStatus(string $reservationStatus): self
    {
        $this->options['reservationStatus'] = $reservationStatus;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadReservationOptions ' . $options . ']';
    }
}

class UpdateReservationOptions extends Options
{
    public function __construct(string $reservationStatus = Values::NONE, string $workerActivitySid = Values::NONE, string $instruction = Values::NONE, string $dequeuePostWorkActivitySid = Values::NONE, string $dequeueFrom = Values::NONE, string $dequeueRecord = Values::NONE, int $dequeueTimeout = Values::NONE, string $dequeueTo = Values::NONE, string $dequeueStatusCallbackUrl = Values::NONE, string $callFrom = Values::NONE, string $callRecord = Values::NONE, int $callTimeout = Values::NONE, string $callTo = Values::NONE, string $callUrl = Values::NONE, string $callStatusCallbackUrl = Values::NONE, bool $callAccept = Values::NONE, string $redirectCallSid = Values::NONE, bool $redirectAccept = Values::NONE, string $redirectUrl = Values::NONE, string $to = Values::NONE, string $from = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, array $statusCallbackEvent = Values::ARRAY_NONE, int $timeout = Values::NONE, bool $record = Values::NONE, bool $muted = Values::NONE, string $beep = Values::NONE, bool $startConferenceOnEnter = Values::NONE, bool $endConferenceOnExit = Values::NONE, string $waitUrl = Values::NONE, string $waitMethod = Values::NONE, bool $earlyMedia = Values::NONE, int $maxParticipants = Values::NONE, string $conferenceStatusCallback = Values::NONE, string $conferenceStatusCallbackMethod = Values::NONE, array $conferenceStatusCallbackEvent = Values::ARRAY_NONE, string $conferenceRecord = Values::NONE, string $conferenceTrim = Values::NONE, string $recordingChannels = Values::NONE, string $recordingStatusCallback = Values::NONE, string $recordingStatusCallbackMethod = Values::NONE, string $conferenceRecordingStatusCallback = Values::NONE, string $conferenceRecordingStatusCallbackMethod = Values::NONE, string $region = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, array $dequeueStatusCallbackEvent = Values::ARRAY_NONE, string $postWorkActivitySid = Values::NONE, string $supervisorMode = Values::NONE, string $supervisor = Values::NONE, bool $endConferenceOnCustomerExit = Values::NONE, bool $beepOnCustomerEntrance = Values::NONE)
    {
        $this->options['reservationStatus'] = $reservationStatus;
        $this->options['workerActivitySid'] = $workerActivitySid;
        $this->options['instruction'] = $instruction;
        $this->options['dequeuePostWorkActivitySid'] = $dequeuePostWorkActivitySid;
        $this->options['dequeueFrom'] = $dequeueFrom;
        $this->options['dequeueRecord'] = $dequeueRecord;
        $this->options['dequeueTimeout'] = $dequeueTimeout;
        $this->options['dequeueTo'] = $dequeueTo;
        $this->options['dequeueStatusCallbackUrl'] = $dequeueStatusCallbackUrl;
        $this->options['callFrom'] = $callFrom;
        $this->options['callRecord'] = $callRecord;
        $this->options['callTimeout'] = $callTimeout;
        $this->options['callTo'] = $callTo;
        $this->options['callUrl'] = $callUrl;
        $this->options['callStatusCallbackUrl'] = $callStatusCallbackUrl;
        $this->options['callAccept'] = $callAccept;
        $this->options['redirectCallSid'] = $redirectCallSid;
        $this->options['redirectAccept'] = $redirectAccept;
        $this->options['redirectUrl'] = $redirectUrl;
        $this->options['to'] = $to;
        $this->options['from'] = $from;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['statusCallbackEvent'] = $statusCallbackEvent;
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
        $this->options['conferenceStatusCallback'] = $conferenceStatusCallback;
        $this->options['conferenceStatusCallbackMethod'] = $conferenceStatusCallbackMethod;
        $this->options['conferenceStatusCallbackEvent'] = $conferenceStatusCallbackEvent;
        $this->options['conferenceRecord'] = $conferenceRecord;
        $this->options['conferenceTrim'] = $conferenceTrim;
        $this->options['recordingChannels'] = $recordingChannels;
        $this->options['recordingStatusCallback'] = $recordingStatusCallback;
        $this->options['recordingStatusCallbackMethod'] = $recordingStatusCallbackMethod;
        $this->options['conferenceRecordingStatusCallback'] = $conferenceRecordingStatusCallback;
        $this->options['conferenceRecordingStatusCallbackMethod'] = $conferenceRecordingStatusCallbackMethod;
        $this->options['region'] = $region;
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        $this->options['dequeueStatusCallbackEvent'] = $dequeueStatusCallbackEvent;
        $this->options['postWorkActivitySid'] = $postWorkActivitySid;
        $this->options['supervisorMode'] = $supervisorMode;
        $this->options['supervisor'] = $supervisor;
        $this->options['endConferenceOnCustomerExit'] = $endConferenceOnCustomerExit;
        $this->options['beepOnCustomerEntrance'] = $beepOnCustomerEntrance;
    }

    public function setReservationStatus(string $reservationStatus): self
    {
        $this->options['reservationStatus'] = $reservationStatus;
        return $this;
    }

    public function setWorkerActivitySid(string $workerActivitySid): self
    {
        $this->options['workerActivitySid'] = $workerActivitySid;
        return $this;
    }

    public function setInstruction(string $instruction): self
    {
        $this->options['instruction'] = $instruction;
        return $this;
    }

    public function setDequeuePostWorkActivitySid(string $dequeuePostWorkActivitySid): self
    {
        $this->options['dequeuePostWorkActivitySid'] = $dequeuePostWorkActivitySid;
        return $this;
    }

    public function setDequeueFrom(string $dequeueFrom): self
    {
        $this->options['dequeueFrom'] = $dequeueFrom;
        return $this;
    }

    public function setDequeueRecord(string $dequeueRecord): self
    {
        $this->options['dequeueRecord'] = $dequeueRecord;
        return $this;
    }

    public function setDequeueTimeout(int $dequeueTimeout): self
    {
        $this->options['dequeueTimeout'] = $dequeueTimeout;
        return $this;
    }

    public function setDequeueTo(string $dequeueTo): self
    {
        $this->options['dequeueTo'] = $dequeueTo;
        return $this;
    }

    public function setDequeueStatusCallbackUrl(string $dequeueStatusCallbackUrl): self
    {
        $this->options['dequeueStatusCallbackUrl'] = $dequeueStatusCallbackUrl;
        return $this;
    }

    public function setCallFrom(string $callFrom): self
    {
        $this->options['callFrom'] = $callFrom;
        return $this;
    }

    public function setCallRecord(string $callRecord): self
    {
        $this->options['callRecord'] = $callRecord;
        return $this;
    }

    public function setCallTimeout(int $callTimeout): self
    {
        $this->options['callTimeout'] = $callTimeout;
        return $this;
    }

    public function setCallTo(string $callTo): self
    {
        $this->options['callTo'] = $callTo;
        return $this;
    }

    public function setCallUrl(string $callUrl): self
    {
        $this->options['callUrl'] = $callUrl;
        return $this;
    }

    public function setCallStatusCallbackUrl(string $callStatusCallbackUrl): self
    {
        $this->options['callStatusCallbackUrl'] = $callStatusCallbackUrl;
        return $this;
    }

    public function setCallAccept(bool $callAccept): self
    {
        $this->options['callAccept'] = $callAccept;
        return $this;
    }

    public function setRedirectCallSid(string $redirectCallSid): self
    {
        $this->options['redirectCallSid'] = $redirectCallSid;
        return $this;
    }

    public function setRedirectAccept(bool $redirectAccept): self
    {
        $this->options['redirectAccept'] = $redirectAccept;
        return $this;
    }

    public function setRedirectUrl(string $redirectUrl): self
    {
        $this->options['redirectUrl'] = $redirectUrl;
        return $this;
    }

    public function setTo(string $to): self
    {
        $this->options['to'] = $to;
        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
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

    public function setRegion(string $region): self
    {
        $this->options['region'] = $region;
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

    public function setDequeueStatusCallbackEvent(array $dequeueStatusCallbackEvent): self
    {
        $this->options['dequeueStatusCallbackEvent'] = $dequeueStatusCallbackEvent;
        return $this;
    }

    public function setPostWorkActivitySid(string $postWorkActivitySid): self
    {
        $this->options['postWorkActivitySid'] = $postWorkActivitySid;
        return $this;
    }

    public function setSupervisorMode(string $supervisorMode): self
    {
        $this->options['supervisorMode'] = $supervisorMode;
        return $this;
    }

    public function setSupervisor(string $supervisor): self
    {
        $this->options['supervisor'] = $supervisor;
        return $this;
    }

    public function setEndConferenceOnCustomerExit(bool $endConferenceOnCustomerExit): self
    {
        $this->options['endConferenceOnCustomerExit'] = $endConferenceOnCustomerExit;
        return $this;
    }

    public function setBeepOnCustomerEntrance(bool $beepOnCustomerEntrance): self
    {
        $this->options['beepOnCustomerEntrance'] = $beepOnCustomerEntrance;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateReservationOptions ' . $options . ']';
    }
}