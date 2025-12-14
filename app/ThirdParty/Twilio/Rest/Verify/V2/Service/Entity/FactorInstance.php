<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

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

class FactorInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $identity, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'entitySid' => Values::array_get($payload, 'entity_sid'), 'identity' => Values::array_get($payload, 'identity'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'status' => Values::array_get($payload, 'status'), 'factorType' => Values::array_get($payload, 'factor_type'), 'config' => Values::array_get($payload, 'config'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity, 'sid' => $sid ?: $this->properties['sid'],];
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): FactorInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): FactorInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Verify.V2.FactorInstance ' . implode(' ', $context) . ']';
    }

    protected function proxy(): FactorContext
    {
        if (!$this->context) {
            $this->context = new FactorContext($this->version, $this->solution['serviceSid'], $this->solution['identity'], $this->solution['sid']);
        }
        return $this->context;
    }
}