<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ApplicationContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Applications/' . rawurlencode($sid) . '.json';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): ApplicationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ApplicationInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(array $options = []): ApplicationInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'ApiVersion' => $options['apiVersion'], 'VoiceUrl' => $options['voiceUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'VoiceCallerIdLookup' => Serialize::booleanToString($options['voiceCallerIdLookup']), 'SmsUrl' => $options['smsUrl'], 'SmsMethod' => $options['smsMethod'], 'SmsFallbackUrl' => $options['smsFallbackUrl'], 'SmsFallbackMethod' => $options['smsFallbackMethod'], 'SmsStatusCallback' => $options['smsStatusCallback'], 'MessageStatusCallback' => $options['messageStatusCallback'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ApplicationInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.ApplicationContext ' . implode(' ', $context) . ']';
    }
}