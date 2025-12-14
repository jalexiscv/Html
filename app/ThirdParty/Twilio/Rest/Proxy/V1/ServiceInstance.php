<?php

namespace Twilio\Rest\Proxy\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Proxy\V1\Service\PhoneNumberList;
use Twilio\Rest\Proxy\V1\Service\SessionList;
use Twilio\Rest\Proxy\V1\Service\ShortCodeList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_sessions;
    protected $_phoneNumbers;
    protected $_shortCodes;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'chatInstanceSid' => Values::array_get($payload, 'chat_instance_sid'), 'callbackUrl' => Values::array_get($payload, 'callback_url'), 'defaultTtl' => Values::array_get($payload, 'default_ttl'), 'numberSelectionBehavior' => Values::array_get($payload, 'number_selection_behavior'), 'geoMatchLevel' => Values::array_get($payload, 'geo_match_level'), 'interceptCallbackUrl' => Values::array_get($payload, 'intercept_callback_url'), 'outOfSessionCallbackUrl' => Values::array_get($payload, 'out_of_session_callback_url'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getSessions(): SessionList
    {
        return $this->proxy()->sessions;
    }

    protected function getPhoneNumbers(): PhoneNumberList
    {
        return $this->proxy()->phoneNumbers;
    }

    protected function getShortCodes(): ShortCodeList
    {
        return $this->proxy()->shortCodes;
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
        return '[Twilio.Proxy.V1.ServiceInstance ' . implode(' ', $context) . ']';
    }
}