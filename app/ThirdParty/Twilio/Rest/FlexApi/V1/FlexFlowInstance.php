<?php

namespace Twilio\Rest\FlexApi\V1;

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

class FlexFlowInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'sid' => Values::array_get($payload, 'sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'chatServiceSid' => Values::array_get($payload, 'chat_service_sid'), 'channelType' => Values::array_get($payload, 'channel_type'), 'contactIdentity' => Values::array_get($payload, 'contact_identity'), 'enabled' => Values::array_get($payload, 'enabled'), 'integrationType' => Values::array_get($payload, 'integration_type'), 'integration' => Values::array_get($payload, 'integration'), 'longLived' => Values::array_get($payload, 'long_lived'), 'janitorEnabled' => Values::array_get($payload, 'janitor_enabled'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): FlexFlowContext
    {
        if (!$this->context) {
            $this->context = new FlexFlowContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): FlexFlowInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): FlexFlowInstance
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
        return '[Twilio.FlexApi.V1.FlexFlowInstance ' . implode(' ', $context) . ']';
    }
}