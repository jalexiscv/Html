<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class AssignedAddOnExtensionContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $resourceSid, $assignedAddOnSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'resourceSid' => $resourceSid, 'assignedAddOnSid' => $assignedAddOnSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/IncomingPhoneNumbers/' . rawurlencode($resourceSid) . '/AssignedAddOns/' . rawurlencode($assignedAddOnSid) . '/Extensions/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): AssignedAddOnExtensionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AssignedAddOnExtensionInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['resourceSid'], $this->solution['assignedAddOnSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.AssignedAddOnExtensionContext ' . implode(' ', $context) . ']';
    }
}