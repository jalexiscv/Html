<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

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

class CredentialListInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $trunkSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'sid' => Values::array_get($payload, 'sid'), 'trunkSid' => Values::array_get($payload, 'trunk_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['trunkSid' => $trunkSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): CredentialListContext
    {
        if (!$this->context) {
            $this->context = new CredentialListContext($this->version, $this->solution['trunkSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): CredentialListInstance
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
        return '[Twilio.Trunking.V1.CredentialListInstance ' . implode(' ', $context) . ']';
    }
}