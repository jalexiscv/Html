<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn\AssignedAddOnExtensionContext;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn\AssignedAddOnExtensionList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class AssignedAddOnContext extends InstanceContext
{
    protected $_extensions;

    public function __construct(Version $version, $accountSid, $resourceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'resourceSid' => $resourceSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/IncomingPhoneNumbers/' . rawurlencode($resourceSid) . '/AssignedAddOns/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): AssignedAddOnInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AssignedAddOnInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['resourceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getExtensions(): AssignedAddOnExtensionList
    {
        if (!$this->_extensions) {
            $this->_extensions = new AssignedAddOnExtensionList($this->version, $this->solution['accountSid'], $this->solution['resourceSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.AssignedAddOnContext ' . implode(' ', $context) . ']';
    }
}