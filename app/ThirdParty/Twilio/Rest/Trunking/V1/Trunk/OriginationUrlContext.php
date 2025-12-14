<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class OriginationUrlContext extends InstanceContext
{
    public function __construct(Version $version, $trunkSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['trunkSid' => $trunkSid, 'sid' => $sid,];
        $this->uri = '/Trunks/' . rawurlencode($trunkSid) . '/OriginationUrls/' . rawurlencode($sid) . '';
    }

    public function fetch(): OriginationUrlInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new OriginationUrlInstance($this->version, $payload, $this->solution['trunkSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): OriginationUrlInstance
    {
        $options = new Values($options);
        $data = Values::of(['Weight' => $options['weight'], 'Priority' => $options['priority'], 'Enabled' => Serialize::booleanToString($options['enabled']), 'FriendlyName' => $options['friendlyName'], 'SipUrl' => $options['sipUrl'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new OriginationUrlInstance($this->version, $payload, $this->solution['trunkSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Trunking.V1.OriginationUrlContext ' . implode(' ', $context) . ']';
    }
}