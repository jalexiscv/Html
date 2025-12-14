<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

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

class RecordingInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $conferenceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'callSid' => Values::array_get($payload, 'call_sid'), 'conferenceSid' => Values::array_get($payload, 'conference_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'startTime' => Deserialize::dateTime(Values::array_get($payload, 'start_time')), 'duration' => Values::array_get($payload, 'duration'), 'sid' => Values::array_get($payload, 'sid'), 'price' => Values::array_get($payload, 'price'), 'priceUnit' => Values::array_get($payload, 'price_unit'), 'status' => Values::array_get($payload, 'status'), 'channels' => Values::array_get($payload, 'channels'), 'source' => Values::array_get($payload, 'source'), 'errorCode' => Values::array_get($payload, 'error_code'), 'encryptionDetails' => Values::array_get($payload, 'encryption_details'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'conferenceSid' => $conferenceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): RecordingContext
    {
        if (!$this->context) {
            $this->context = new RecordingContext($this->version, $this->solution['accountSid'], $this->solution['conferenceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(string $status, array $options = []): RecordingInstance
    {
        return $this->proxy()->update($status, $options);
    }

    public function fetch(): RecordingInstance
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
        return '[Twilio.Api.V2010.RecordingInstance ' . implode(' ', $context) . ']';
    }
}