<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ConfigurationContext extends InstanceContext
{
    public function __construct(Version $version, $chatServiceSid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid,];
        $this->uri = '/Services/' . rawurlencode($chatServiceSid) . '/Configuration';
    }

    public function fetch(): ConfigurationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ConfigurationInstance($this->version, $payload, $this->solution['chatServiceSid']);
    }

    public function update(array $options = []): ConfigurationInstance
    {
        $options = new Values($options);
        $data = Values::of(['DefaultConversationCreatorRoleSid' => $options['defaultConversationCreatorRoleSid'], 'DefaultConversationRoleSid' => $options['defaultConversationRoleSid'], 'DefaultChatServiceRoleSid' => $options['defaultChatServiceRoleSid'], 'ReachabilityEnabled' => Serialize::booleanToString($options['reachabilityEnabled']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ConfigurationInstance($this->version, $payload, $this->solution['chatServiceSid']);
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