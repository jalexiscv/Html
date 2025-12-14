<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class EventInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $callSid)
    {
        parent::__construct($version);
        $this->properties = ['timestamp' => Values::array_get($payload, 'timestamp'), 'callSid' => Values::array_get($payload, 'call_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'edge' => Values::array_get($payload, 'edge'), 'group' => Values::array_get($payload, 'group'), 'level' => Values::array_get($payload, 'level'), 'name' => Values::array_get($payload, 'name'), 'carrierEdge' => Values::array_get($payload, 'carrier_edge'), 'sipEdge' => Values::array_get($payload, 'sip_edge'), 'sdkEdge' => Values::array_get($payload, 'sdk_edge'), 'clientEdge' => Values::array_get($payload, 'client_edge'),];
        $this->solution = ['callSid' => $callSid,];
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
        return '[Twilio.Insights.V1.EventInstance]';
    }
}