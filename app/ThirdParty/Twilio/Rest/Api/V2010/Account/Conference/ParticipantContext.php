<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ParticipantContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $conferenceSid, $callSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'conferenceSid' => $conferenceSid, 'callSid' => $callSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Conferences/' . rawurlencode($conferenceSid) . '/Participants/' . rawurlencode($callSid) . '.json';
    }

    public function fetch(): ParticipantInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ParticipantInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['conferenceSid'], $this->solution['callSid']);
    }

    public function update(array $options = []): ParticipantInstance
    {
        $options = new Values($options);
        $data = Values::of(['Muted' => Serialize::booleanToString($options['muted']), 'Hold' => Serialize::booleanToString($options['hold']), 'HoldUrl' => $options['holdUrl'], 'HoldMethod' => $options['holdMethod'], 'AnnounceUrl' => $options['announceUrl'], 'AnnounceMethod' => $options['announceMethod'], 'WaitUrl' => $options['waitUrl'], 'WaitMethod' => $options['waitMethod'], 'BeepOnExit' => Serialize::booleanToString($options['beepOnExit']), 'EndConferenceOnExit' => Serialize::booleanToString($options['endConferenceOnExit']), 'Coaching' => Serialize::booleanToString($options['coaching']), 'CallSidToCoach' => $options['callSidToCoach'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ParticipantInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['conferenceSid'], $this->solution['callSid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.ParticipantContext ' . implode(' ', $context) . ']';
    }
}