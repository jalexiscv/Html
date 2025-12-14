<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class CertificateContext extends InstanceContext
{
    public function __construct(Version $version, $fleetSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['fleetSid' => $fleetSid, 'sid' => $sid,];
        $this->uri = '/Fleets/' . rawurlencode($fleetSid) . '/Certificates/' . rawurlencode($sid) . '';
    }

    public function fetch(): CertificateInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CertificateInstance($this->version, $payload, $this->solution['fleetSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): CertificateInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DeviceSid' => $options['deviceSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new CertificateInstance($this->version, $payload, $this->solution['fleetSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.DeployedDevices.CertificateContext ' . implode(' ', $context) . ']';
    }
}