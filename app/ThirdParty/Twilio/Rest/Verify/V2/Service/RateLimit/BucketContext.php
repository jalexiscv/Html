<?php

namespace Twilio\Rest\Verify\V2\Service\RateLimit;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class BucketContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $rateLimitSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'rateLimitSid' => $rateLimitSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/RateLimits/' . rawurlencode($rateLimitSid) . '/Buckets/' . rawurlencode($sid) . '';
    }

    public function update(array $options = []): BucketInstance
    {
        $options = new Values($options);
        $data = Values::of(['Max' => $options['max'], 'Interval' => $options['interval'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new BucketInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['rateLimitSid'], $this->solution['sid']);
    }

    public function fetch(): BucketInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BucketInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['rateLimitSid'], $this->solution['sid']);
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
        return '[Twilio.Verify.V2.BucketContext ' . implode(' ', $context) . ']';
    }
}