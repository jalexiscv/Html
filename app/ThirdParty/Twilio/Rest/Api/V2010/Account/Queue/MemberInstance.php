<?php

namespace Twilio\Rest\Api\V2010\Account\Queue;

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

class MemberInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $queueSid, string $callSid = null)
    {
        parent::__construct($version);
        $this->properties = ['callSid' => Values::array_get($payload, 'call_sid'), 'dateEnqueued' => Deserialize::dateTime(Values::array_get($payload, 'date_enqueued')), 'position' => Values::array_get($payload, 'position'), 'uri' => Values::array_get($payload, 'uri'), 'waitTime' => Values::array_get($payload, 'wait_time'), 'queueSid' => Values::array_get($payload, 'queue_sid'),];
        $this->solution = ['accountSid' => $accountSid, 'queueSid' => $queueSid, 'callSid' => $callSid ?: $this->properties['callSid'],];
    }

    protected function proxy(): MemberContext
    {
        if (!$this->context) {
            $this->context = new MemberContext($this->version, $this->solution['accountSid'], $this->solution['queueSid'], $this->solution['callSid']);
        }
        return $this->context;
    }

    public function fetch(): MemberInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(string $url, array $options = []): MemberInstance
    {
        return $this->proxy()->update($url, $options);
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
        return '[Twilio.Api.V2010.MemberInstance ' . implode(' ', $context) . ']';
    }
}