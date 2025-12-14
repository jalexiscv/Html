<?php

namespace Twilio\Rest\Preview\Marketplace\InstalledAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class InstalledAddOnExtensionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $installedAddOnSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'installedAddOnSid' => Values::array_get($payload, 'installed_add_on_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'productName' => Values::array_get($payload, 'product_name'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'enabled' => Values::array_get($payload, 'enabled'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['installedAddOnSid' => $installedAddOnSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): InstalledAddOnExtensionContext
    {
        if (!$this->context) {
            $this->context = new InstalledAddOnExtensionContext($this->version, $this->solution['installedAddOnSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): InstalledAddOnExtensionInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(bool $enabled): InstalledAddOnExtensionInstance
    {
        return $this->proxy()->update($enabled);
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
        return '[Twilio.Preview.Marketplace.InstalledAddOnExtensionInstance ' . implode(' ', $context) . ']';
    }
}