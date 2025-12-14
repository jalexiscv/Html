<?php

namespace Twilio\Rest\Preview\Wireless;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Preview\Wireless\Sim\UsageList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SimInstance extends InstanceResource
{
    protected $_usage;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'ratePlanSid' => Values::array_get($payload, 'rate_plan_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'iccid' => Values::array_get($payload, 'iccid'), 'eId' => Values::array_get($payload, 'e_id'), 'status' => Values::array_get($payload, 'status'), 'commandsCallbackUrl' => Values::array_get($payload, 'commands_callback_url'), 'commandsCallbackMethod' => Values::array_get($payload, 'commands_callback_method'), 'smsFallbackMethod' => Values::array_get($payload, 'sms_fallback_method'), 'smsFallbackUrl' => Values::array_get($payload, 'sms_fallback_url'), 'smsMethod' => Values::array_get($payload, 'sms_method'), 'smsUrl' => Values::array_get($payload, 'sms_url'), 'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'), 'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'), 'voiceMethod' => Values::array_get($payload, 'voice_method'), 'voiceUrl' => Values::array_get($payload, 'voice_url'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): SimContext
    {
        if (!$this->context) {
            $this->context = new SimContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): SimInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): SimInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getUsage(): UsageList
    {
        return $this->proxy()->usage;
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
        return '[Twilio.Preview.Wireless.SimInstance ' . implode(' ', $context) . ']';
    }
}