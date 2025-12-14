<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class AssistantInitiationActionsContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/InitiationActions';
    }

    public function fetch(): AssistantInitiationActionsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AssistantInitiationActionsInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function update(array $options = []): AssistantInitiationActionsInstance
    {
        $options = new Values($options);
        $data = Values::of(['InitiationActions' => Serialize::jsonObject($options['initiationActions']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new AssistantInitiationActionsInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Understand.AssistantInitiationActionsContext ' . implode(' ', $context) . ']';
    }
}