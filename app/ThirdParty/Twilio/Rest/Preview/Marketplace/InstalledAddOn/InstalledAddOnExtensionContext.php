<?php

namespace Twilio\Rest\Preview\Marketplace\InstalledAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class InstalledAddOnExtensionContext extends InstanceContext
{
    public function __construct(Version $version, $installedAddOnSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['installedAddOnSid' => $installedAddOnSid, 'sid' => $sid,];
        $this->uri = '/InstalledAddOns/' . rawurlencode($installedAddOnSid) . '/Extensions/' . rawurlencode($sid) . '';
    }

    public function fetch(): InstalledAddOnExtensionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new InstalledAddOnExtensionInstance($this->version, $payload, $this->solution['installedAddOnSid'], $this->solution['sid']);
    }

    public function update(bool $enabled): InstalledAddOnExtensionInstance
    {
        $data = Values::of(['Enabled' => Serialize::booleanToString($enabled),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new InstalledAddOnExtensionInstance($this->version, $payload, $this->solution['installedAddOnSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Marketplace.InstalledAddOnExtensionContext ' . implode(' ', $context) . ']';
    }
}