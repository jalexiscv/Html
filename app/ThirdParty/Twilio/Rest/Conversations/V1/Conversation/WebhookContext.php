<?php

namespace Twilio\Rest\Conversations\V1\Conversation;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WebhookContext extends InstanceContext
{
    public function __construct(Version $version, $conversationSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['conversationSid' => $conversationSid, 'sid' => $sid,];
        $this->uri = '/Conversations/' . rawurlencode($conversationSid) . '/Webhooks/' . rawurlencode($sid) . '';
    }

    public function fetch(): WebhookInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WebhookInstance($this->version, $payload, $this->solution['conversationSid'], $this->solution['sid']);
    }

    public function update(array $options = []): WebhookInstance
    {
        $options = new Values($options);
        $data = Values::of(['Configuration.Url' => $options['configurationUrl'], 'Configuration.Method' => $options['configurationMethod'], 'Configuration.Filters' => Serialize::map($options['configurationFilters'], function ($e) {
            return $e;
        }), 'Configuration.Triggers' => Serialize::map($options['configurationTriggers'], function ($e) {
            return $e;
        }), 'Configuration.FlowSid' => $options['configurationFlowSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WebhookInstance($this->version, $payload, $this->solution['conversationSid'], $this->solution['sid']);
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
        return '[Twilio.Conversations.V1.WebhookContext ' . implode(' ', $context) . ']';
    }
}