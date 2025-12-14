<?php

namespace Twilio\Rest\Verify\V2\Service;

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

class VerificationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'to' => Values::array_get($payload, 'to'), 'channel' => Values::array_get($payload, 'channel'), 'status' => Values::array_get($payload, 'status'), 'valid' => Values::array_get($payload, 'valid'), 'lookup' => Values::array_get($payload, 'lookup'), 'amount' => Values::array_get($payload, 'amount'), 'payee' => Values::array_get($payload, 'payee'), 'sendCodeAttempts' => Values::array_get($payload, 'send_code_attempts'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): VerificationContext
    {
        if (!$this->context) {
            $this->context = new VerificationContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(string $status): VerificationInstance
    {
        return $this->proxy()->update($status);
    }

    public function fetch(): VerificationInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Verify.V2.VerificationInstance ' . implode(' ', $context) . ']';
    }
}