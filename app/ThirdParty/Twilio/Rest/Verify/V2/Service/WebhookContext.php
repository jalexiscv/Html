<?php

namespace Twilio\Rest\Verify\V2\Service;

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
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Webhooks/' . rawurlencode($sid) . '';
    }

    public function update(array $options = []): WebhookInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'EventTypes' => Serialize::map($options['eventTypes'], function ($e) {
            return $e;
        }), 'WebhookUrl' => $options['webhookUrl'], 'Status' => $options['status'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WebhookInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): WebhookInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WebhookInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Verify.V2.WebhookContext ' . implode(' ', $context) . ']';
    }
}