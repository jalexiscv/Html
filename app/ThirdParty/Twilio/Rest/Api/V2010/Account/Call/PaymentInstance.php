<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

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

class PaymentInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $callSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'callSid' => Values::array_get($payload, 'call_sid'), 'sid' => Values::array_get($payload, 'sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): PaymentContext
    {
        if (!$this->context) {
            $this->context = new PaymentContext($this->version, $this->solution['accountSid'], $this->solution['callSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(string $idempotencyKey, string $statusCallback, array $options = []): PaymentInstance
    {
        return $this->proxy()->update($idempotencyKey, $statusCallback, $options);
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
        return '[Twilio.Api.V2010.PaymentInstance ' . implode(' ', $context) . ']';
    }
}