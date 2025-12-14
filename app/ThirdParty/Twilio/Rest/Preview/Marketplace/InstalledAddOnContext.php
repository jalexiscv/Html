<?php

namespace Twilio\Rest\Preview\Marketplace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\Marketplace\InstalledAddOn\InstalledAddOnExtensionContext;
use Twilio\Rest\Preview\Marketplace\InstalledAddOn\InstalledAddOnExtensionList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class InstalledAddOnContext extends InstanceContext
{
    protected $_extensions;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/InstalledAddOns/' . rawurlencode($sid) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): InstalledAddOnInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new InstalledAddOnInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): InstalledAddOnInstance
    {
        $options = new Values($options);
        $data = Values::of(['Configuration' => Serialize::jsonObject($options['configuration']), 'UniqueName' => $options['uniqueName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new InstalledAddOnInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getExtensions(): InstalledAddOnExtensionList
    {
        if (!$this->_extensions) {
            $this->_extensions = new InstalledAddOnExtensionList($this->version, $this->solution['sid']);
        }
        return $this->_extensions;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Marketplace.InstalledAddOnContext ' . implode(' ', $context) . ']';
    }
}