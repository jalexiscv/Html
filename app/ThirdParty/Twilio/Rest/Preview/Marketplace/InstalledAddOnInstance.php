<?php

namespace Twilio\Rest\Preview\Marketplace;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Preview\Marketplace\InstalledAddOn\InstalledAddOnExtensionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class InstalledAddOnInstance extends InstanceResource
{
    protected $_extensions;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'description' => Values::array_get($payload, 'description'), 'configuration' => Values::array_get($payload, 'configuration'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): InstalledAddOnContext
    {
        if (!$this->context) {
            $this->context = new InstalledAddOnContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): InstalledAddOnInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): InstalledAddOnInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getExtensions(): InstalledAddOnExtensionList
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
        return '[Twilio.Preview.Marketplace.InstalledAddOnInstance ' . implode(' ', $context) . ']';
    }
}