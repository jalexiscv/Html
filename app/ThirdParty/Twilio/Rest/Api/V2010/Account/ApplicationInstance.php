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

class ApplicationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'messageStatusCallback' => Values::array_get($payload, 'message_status_callback'), 'sid' => Values::array_get($payload, 'sid'), 'smsFallbackMethod' => Values::array_get($payload, 'sms_fallback_method'), 'smsFallbackUrl' => Values::array_get($payload, 'sms_fallback_url'), 'smsMethod' => Values::array_get($payload, 'sms_method'), 'smsStatusCallback' => Values::array_get($payload, 'sms_status_callback'), 'smsUrl' => Values::array_get($payload, 'sms_url'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'uri' => Values::array_get($payload, 'uri'), 'voiceCallerIdLookup' => Values::array_get($payload, 'voice_caller_id_lookup'), 'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'), 'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'), 'voiceMethod' => Values::array_get($payload, 'voice_method'), 'voiceUrl' => Values::array_get($payload, 'voice_url'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ApplicationContext
    {
        if (!$this->context) {
            $this->context = new ApplicationContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): ApplicationInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ApplicationInstance
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
        return '[Twilio.Api.V2010.ApplicationInstance ' . implode(' ', $context) . ']';
    }
}