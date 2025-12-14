<?php

namespace Twilio\Rest\Preview\Marketplace\AvailableAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AvailableAddOnExtensionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $availableAddOnSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'availableAddOnSid' => Values::array_get($payload, 'available_add_on_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'productName' => Values::array_get($payload, 'product_name'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['availableAddOnSid' => $availableAddOnSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AvailableAddOnExtensionContext
    {
        if (!$this->context) {
            $this->context = new AvailableAddOnExtensionContext($this->version, $this->solution['availableAddOnSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AvailableAddOnExtensionInstance
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
        return '[Twilio.Preview.Marketplace.AvailableAddOnExtensionInstance ' . implode(' ', $context) . ']';
    }
}