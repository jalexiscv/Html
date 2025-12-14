<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SourceIpMappingContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/SourceIpMappings/' . rawurlencode($sid) . '';
    }

    public function fetch(): SourceIpMappingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SourceIpMappingInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(string $sipDomainSid): SourceIpMappingInstance
    {
        $data = Values::of(['SipDomainSid' => $sipDomainSid,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SourceIpMappingInstance($this->version, $payload, $this->solution['sid']);
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
        return '[Twilio.Voice.V1.SourceIpMappingContext ' . implode(' ', $context) . ']';
    }
}