<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class PhoneNumberContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/PhoneNumbers/' . rawurlencode($sid) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): PhoneNumberInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new PhoneNumberInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function update(array $options = []): PhoneNumberInstance
    {
        $options = new Values($options);
        $data = Values::of(['IsReserved' => Serialize::booleanToString($options['isReserved']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new PhoneNumberInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Proxy.V1.PhoneNumberContext ' . implode(' ', $context) . ']';
    }
}