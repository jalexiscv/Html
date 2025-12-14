<?php

namespace Twilio\Rest\Voice\V1;

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

class ByocTrunkInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'sid' => Values::array_get($payload, 'sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'voiceUrl' => Values::array_get($payload, 'voice_url'), 'voiceMethod' => Values::array_get($payload, 'voice_method'), 'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'), 'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'), 'statusCallbackUrl' => Values::array_get($payload, 'status_callback_url'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'cnamLookupEnabled' => Values::array_get($payload, 'cnam_lookup_enabled'), 'connectionPolicySid' => Values::array_get($payload, 'connection_policy_sid'), 'fromDomainSid' => Values::array_get($payload, 'from_domain_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ByocTrunkContext
    {
        if (!$this->context) {
            $this->context = new ByocTrunkContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ByocTrunkInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ByocTrunkInstance
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
        return '[Twilio.Voice.V1.ByocTrunkInstance ' . implode(' ', $context) . ']';
    }
}