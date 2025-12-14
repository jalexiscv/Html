<?php

namespace Twilio\Rest\Notify\V1\Service;

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

class BindingInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'credentialSid' => Values::array_get($payload, 'credential_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'notificationProtocolVersion' => Values::array_get($payload, 'notification_protocol_version'), 'endpoint' => Values::array_get($payload, 'endpoint'), 'identity' => Values::array_get($payload, 'identity'), 'bindingType' => Values::array_get($payload, 'binding_type'), 'address' => Values::array_get($payload, 'address'), 'tags' => Values::array_get($payload, 'tags'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): BindingContext
    {
        if (!$this->context) {
            $this->context = new BindingContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): BindingInstance
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
        return '[Twilio.Notify.V1.BindingInstance ' . implode(' ', $context) . ']';
    }
}