<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ParticipantList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $conferenceSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'conferenceSid' => $conferenceSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Conferences/' . rawurlencode($conferenceSid) . '/Participants.json';
    }

    public function create(string $from, string $to, array $options = []): ParticipantInstance
    {
        $options = new Values($options);
        $data = Values::of(['From' => $from, 'To' => $to, 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'StatusCallbackEvent' => Serialize::map($options['statusCallbackEvent'], function ($e) {
            return $e;
        }), 'Label' => $options['label'], 'Timeout' => $options['timeout'], 'Record' => Serialize::booleanToString($options['record']), 'Muted' => Serialize::booleanToString($options['muted']), 'Beep' => $options['beep'], 'StartConferenceOnEnter' => Serialize::booleanToString($options['startConferenceOnEnter']), 'EndConferenceOnExit' => Serialize::booleanToString($options['endConferenceOnExit']), 'WaitUrl' => $options['waitUrl'], 'WaitMethod' => $options['waitMethod'], 'EarlyMedia' => Serialize::booleanToString($options['earlyMedia']), 'MaxParticipants' => $options['maxParticipants'], 'ConferenceRecord' => $options['conferenceRecord'], 'ConferenceTrim' => $options['conferenceTrim'], 'ConferenceStatusCallback' => $options['conferenceStatusCallback'], 'ConferenceStatusCallbackMethod' => $options['conferenceStatusCallbackMethod'], 'ConferenceStatusCallbackEvent' => Serialize::map($options['conferenceStatusCallbackEvent'], function ($e) {
            return $e;
        }), 'RecordingChannels' => $options['recordingChannels'], 'RecordingStatusCallback' => $options['recordingStatusCallback'], 'RecordingStatusCallbackMethod' => $options['recordingStatusCallbackMethod'], 'SipAuthUsername' => $options['sipAuthUsername'], 'SipAuthPassword' => $options['sipAuthPassword'], 'Region' => $options['region'], 'ConferenceRecordingStatusCallback' => $options['conferenceRecordingStatusCallback'], 'ConferenceRecordingStatusCallbackMethod' => $options['conferenceRecordingStatusCallbackMethod'], 'RecordingStatusCallbackEvent' => Serialize::map($options['recordingStatusCallbackEvent'], function ($e) {
            return $e;
        }), 'ConferenceRecordingStatusCallbackEvent' => Serialize::map($options['conferenceRecordingStatusCallbackEvent'], function ($e) {
            return $e;
        }), 'Coaching' => Serialize::booleanToString($options['coaching']), 'CallSidToCoach' => $options['callSidToCoach'], 'JitterBufferSize' => $options['jitterBufferSize'], 'Byoc' => $options['byoc'], 'CallerId' => $options['callerId'], 'CallReason' => $options['callReason'], 'RecordingTrack' => $options['recordingTrack'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ParticipantInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['conferenceSid']);
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ParticipantPage
    {
        $options = new Values($options);
        $params = Values::of(['Muted' => Serialize::booleanToString($options['muted']), 'Hold' => Serialize::booleanToString($options['hold']), 'Coaching' => Serialize::booleanToString($options['coaching']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ParticipantPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function getContext(string $callSid): ParticipantContext
    {
        return new ParticipantContext($this->version, $this->solution['accountSid'], $this->solution['conferenceSid'], $callSid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.ParticipantList]';
    }
}