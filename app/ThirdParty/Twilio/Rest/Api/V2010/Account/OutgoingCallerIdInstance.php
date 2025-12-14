<?php

namespace Twilio\Rest\Api\V2010\Account;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class OutgoingCallerIdInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): OutgoingCallerIdContext
    {
        if (!$this->context) {
            $this->context = new OutgoingCallerIdContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): OutgoingCallerIdInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): OutgoingCallerIdInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Api.V2010.OutgoingCallerIdInstance ' . implode(' ', $context) . ']';
    }
}