<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AssignedAddOnExtensionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $resourceSid, string $assignedAddOnSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'resourceSid' => Values::array_get($payload, 'resource_sid'), 'assignedAddOnSid' => Values::array_get($payload, 'assigned_add_on_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'productName' => Values::array_get($payload, 'product_name'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'uri' => Values::array_get($payload, 'uri'), 'enabled' => Values::array_get($payload, 'enabled'),];
        $this->solution = ['accountSid' => $accountSid, 'resourceSid' => $resourceSid, 'assignedAddOnSid' => $assignedAddOnSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AssignedAddOnExtensionContext
    {
        if (!$this->context) {
            $this->context = new AssignedAddOnExtensionContext($this->version, $this->solution['accountSid'], $this->solution['resourceSid'], $this->solution['assignedAddOnSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AssignedAddOnExtensionInstance
    {
        return $this->proxy()->fetch();
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.AssignedAddOnExtensionInstance ' . implode(' ', $context) . ']';
    }
}