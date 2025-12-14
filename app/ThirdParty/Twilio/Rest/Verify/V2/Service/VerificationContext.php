<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class VerificationContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Verifications/' . rawurlencode($sid) . '';
    }

    public function update(string $status): VerificationInstance
    {
        $data = Values::of(['Status' => $status,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new VerificationInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function fetch(): VerificationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new VerificationInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Verify.V2.VerificationContext ' . implode(' ', $context) . ']';
    }
}