<?php

namespace Twilio\Rest\Preview\Marketplace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Preview\Marketplace\AvailableAddOn\AvailableAddOnExtensionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AvailableAddOnInstance extends InstanceResource
{
    protected $_extensions;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'description' => Values::array_get($payload, 'description'), 'pricingType' => Values::array_get($payload, 'pricing_type'), 'configurationSchema' => Values::array_get($payload, 'configuration_schema'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AvailableAddOnContext
    {
        if (!$this->context) {
            $this->context = new AvailableAddOnContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AvailableAddOnInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getExtensions(): AvailableAddOnExtensionList
    {
        return $this->proxy()->extensions;
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
        return '[Twilio.Preview.Marketplace.AvailableAddOnInstance ' . implode(' ', $context) . ']';
    }
}