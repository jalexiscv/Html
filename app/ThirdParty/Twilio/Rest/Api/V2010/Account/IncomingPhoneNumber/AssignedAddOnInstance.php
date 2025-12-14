<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn\AssignedAddOnExtensionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AssignedAddOnInstance extends InstanceResource
{
    protected $_extensions;

    public function __construct(Version $version, array $payload, string $accountSid, string $resourceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'resourceSid' => Values::array_get($payload, 'resource_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'description' => Values::array_get($payload, 'description'), 'configuration' => Values::array_get($payload, 'configuration'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'uri' => Values::array_get($payload, 'uri'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'),];
        $this->solution = ['accountSid' => $accountSid, 'resourceSid' => $resourceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AssignedAddOnContext
    {
        if (!$this->context) {
            $this->context = new AssignedAddOnContext($this->version, $this->solution['accountSid'], $this->solution['resourceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AssignedAddOnInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getExtensions(): AssignedAddOnExtensionList
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
        return '[Twilio.Api.V2010.AssignedAddOnInstance ' . implode(' ', $context) . ']';
    }
}