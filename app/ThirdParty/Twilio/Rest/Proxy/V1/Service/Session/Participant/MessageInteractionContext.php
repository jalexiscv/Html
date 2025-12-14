<?php

namespace Twilio\Rest\Proxy\V1\Service\Session\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class MessageInteractionContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $sessionSid, $participantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid, 'participantSid' => $participantSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions/' . rawurlencode($sessionSid) . '/Participants/' . rawurlencode($participantSid) . '/MessageInteractions/' . rawurlencode($sid) . '';
    }

    public function fetch(): MessageInteractionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new MessageInteractionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['participantSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Proxy.V1.MessageInteractionContext ' . implode(' ', $context) . ']';
    }
}