<?php

namespace Twilio\Rest\Wireless\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class RatePlanContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/RatePlans/' . rawurlencode($sid) . '';
    }

    public function fetch(): RatePlanInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RatePlanInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): RatePlanInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'FriendlyName' => $options['friendlyName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RatePlanInstance($this->version, $payload, $this->solution['sid']);
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
        return '[Twilio.Wireless.V1.RatePlanContext ' . implode(' ', $context) . ']';
    }
}