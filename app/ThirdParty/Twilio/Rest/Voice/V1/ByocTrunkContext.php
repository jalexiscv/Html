<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ByocTrunkContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/ByocTrunks/' . rawurlencode($sid) . '';
    }

    public function fetch(): ByocTrunkInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ByocTrunkInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): ByocTrunkInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'VoiceUrl' => $options['voiceUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'StatusCallbackUrl' => $options['statusCallbackUrl'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'CnamLookupEnabled' => Serialize::booleanToString($options['cnamLookupEnabled']), 'ConnectionPolicySid' => $options['connectionPolicySid'], 'FromDomainSid' => $options['fromDomainSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ByocTrunkInstance($this->version, $payload, $this->solution['sid']);
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
        return '[Twilio.Voice.V1.ByocTrunkContext ' . implode(' ', $context) . ']';
    }
}