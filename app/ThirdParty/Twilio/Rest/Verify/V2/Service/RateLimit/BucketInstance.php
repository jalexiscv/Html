<?php

namespace Twilio\Rest\Verify\V2\Service\RateLimit;

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

class BucketInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $rateLimitSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'rateLimitSid' => Values::array_get($payload, 'rate_limit_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'max' => Values::array_get($payload, 'max'), 'interval' => Values::array_get($payload, 'interval'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'rateLimitSid' => $rateLimitSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): BucketContext
    {
        if (!$this->context) {
            $this->context = new BucketContext($this->version, $this->solution['serviceSid'], $this->solution['rateLimitSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): BucketInstance
    {
        return $this->proxy()->update($options);
    }

    public function fetch(): BucketInstance
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
        return '[Twilio.Verify.V2.BucketInstance ' . implode(' ', $context) . ']';
    }
}