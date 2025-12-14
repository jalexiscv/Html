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

class AssistantFallbackActionsContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/FallbackActions';
    }

    public function fetch(): AssistantFallbackActionsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AssistantFallbackActionsInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function update(array $options = []): AssistantFallbackActionsInstance
    {
        $options = new Values($options);
        $data = Values::of(['FallbackActions' => Serialize::jsonObject($options['fallbackActions']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new AssistantFallbackActionsInstance($this->version, $payload, $this->solution['assistantSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Understand.AssistantFallbackActionsContext ' . implode(' ', $context) . ']';
    }
}