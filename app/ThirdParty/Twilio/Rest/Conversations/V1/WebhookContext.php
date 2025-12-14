<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;

class WebhookContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Conversations/Webhooks';
    }

    public function fetch(): WebhookInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WebhookInstance($this->version, $payload);
    }

    public function update(array $options = []): WebhookInstance
    {
        $options = new Values($options);
        $data = Values::of(['Method' => $options['method'], 'Filters' => Serialize::map($options['filters'], function ($e) {
            return $e;
        }), 'PreWebhookUrl' => $options['preWebhookUrl'], 'PostWebhookUrl' => $options['postWebhookUrl'], 'Target' => $options['target'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WebhookInstance($this->version, $payload);
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