<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class DialogueContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Dialogues/' . rawurlencode($sid) . '';
    }

    public function fetch(): DialogueInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DialogueInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Autopilot.V1.DialogueContext ' . implode(' ', $context) . ']';
    }
}