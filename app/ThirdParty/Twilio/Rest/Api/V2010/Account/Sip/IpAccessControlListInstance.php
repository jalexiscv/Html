<?php

namespace Twilio\Rest\Api\V2010\Account\Sip;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList\IpAddressList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class IpAccessControlListInstance extends InstanceResource
{
    protected $_ipAddresses;

    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): IpAccessControlListContext
    {
        if (!$this->context) {
            $this->context = new IpAccessControlListContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): IpAccessControlListInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(string $friendlyName): IpAccessControlListInstance
    {
        return $this->proxy()->update($friendlyName);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getIpAddresses(): IpAddressList
    {
        return $this->proxy()->ipAddresses;
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
        return '[Twilio.Api.V2010.IpAccessControlListInstance ' . implode(' ', $context) . ']';
    }
}