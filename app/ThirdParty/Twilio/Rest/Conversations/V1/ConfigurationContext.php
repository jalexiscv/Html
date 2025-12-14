<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;

class ConfigurationContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Configuration';
    }

    public function fetch(): ConfigurationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ConfigurationInstance($this->version, $payload);
    }

    public function update(array $options = []): ConfigurationInstance
    {
        $options = new Values($options);
        $data = Values::of(['DefaultChatServiceSid' => $options['defaultChatServiceSid'], 'DefaultMessagingServiceSid' => $options['defaultMessagingServiceSid'], 'DefaultInactiveTimer' => $options['defaultInactiveTimer'], 'DefaultClosedTimer' => $options['defaultClosedTimer'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ConfigurationInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.ConfigurationContext ' . implode(' ', $context) . ']';
    }
}