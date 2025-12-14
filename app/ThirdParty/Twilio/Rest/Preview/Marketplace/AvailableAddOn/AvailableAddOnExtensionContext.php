<?php

namespace Twilio\Rest\Preview\Marketplace\AvailableAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class AvailableAddOnExtensionContext extends InstanceContext
{
    public function __construct(Version $version, $availableAddOnSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['availableAddOnSid' => $availableAddOnSid, 'sid' => $sid,];
        $this->uri = '/AvailableAddOns/' . rawurlencode($availableAddOnSid) . '/Extensions/' . rawurlencode($sid) . '';
    }

    public function fetch(): AvailableAddOnExtensionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AvailableAddOnExtensionInstance($this->version, $payload, $this->solution['availableAddOnSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Marketplace.AvailableAddOnExtensionContext ' . implode(' ', $context) . ']';
    }
}