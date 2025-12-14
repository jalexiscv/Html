<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ItemAssignmentInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $bundleSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'bundleSid' => Values::array_get($payload, 'bundle_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'objectSid' => Values::array_get($payload, 'object_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['bundleSid' => $bundleSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ItemAssignmentContext
    {
        if (!$this->context) {
            $this->context = new ItemAssignmentContext($this->version, $this->solution['bundleSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ItemAssignmentInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Numbers.V2.ItemAssignmentInstance ' . implode(' ', $context) . ']';
    }
}