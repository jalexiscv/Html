<?php

namespace Twilio\Rest\Api\V2010\Account\Usage;

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

class TriggerInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'callbackMethod' => Values::array_get($payload, 'callback_method'), 'callbackUrl' => Values::array_get($payload, 'callback_url'), 'currentValue' => Values::array_get($payload, 'current_value'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateFired' => Deserialize::dateTime(Values::array_get($payload, 'date_fired')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'recurring' => Values::array_get($payload, 'recurring'), 'sid' => Values::array_get($payload, 'sid'), 'triggerBy' => Values::array_get($payload, 'trigger_by'), 'triggerValue' => Values::array_get($payload, 'trigger_value'), 'uri' => Values::array_get($payload, 'uri'), 'usageCategory' => Values::array_get($payload, 'usage_category'), 'usageRecordUri' => Values::array_get($payload, 'usage_record_uri'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): TriggerContext
    {
        if (!$this->context) {
            $this->context = new TriggerContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): TriggerInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): TriggerInstance
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
        return '[Twilio.Api.V2010.TriggerInstance ' . implode(' ', $context) . ']';
    }
}