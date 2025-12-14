<?php

namespace Twilio\Rest\Insights\V1\Call;

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

class CallSummaryInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $callSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'callSid' => Values::array_get($payload, 'call_sid'), 'callType' => Values::array_get($payload, 'call_type'), 'callState' => Values::array_get($payload, 'call_state'), 'processingState' => Values::array_get($payload, 'processing_state'), 'createdTime' => Deserialize::dateTime(Values::array_get($payload, 'created_time')), 'startTime' => Deserialize::dateTime(Values::array_get($payload, 'start_time')), 'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')), 'duration' => Values::array_get($payload, 'duration'), 'connectDuration' => Values::array_get($payload, 'connect_duration'), 'from' => Values::array_get($payload, 'from'), 'to' => Values::array_get($payload, 'to'), 'carrierEdge' => Values::array_get($payload, 'carrier_edge'), 'clientEdge' => Values::array_get($payload, 'client_edge'), 'sdkEdge' => Values::array_get($payload, 'sdk_edge'), 'sipEdge' => Values::array_get($payload, 'sip_edge'), 'tags' => Values::array_get($payload, 'tags'), 'url' => Values::array_get($payload, 'url'), 'attributes' => Values::array_get($payload, 'attributes'), 'properties' => Values::array_get($payload, 'properties'), 'trust' => Values::array_get($payload, 'trust'),];
        $this->solution = ['callSid' => $callSid,];
    }

    protected function proxy(): CallSummaryContext
    {
        if (!$this->context) {
            $this->context = new CallSummaryContext($this->version, $this->solution['callSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): CallSummaryInstance
    {
        return $this->proxy()->fetch($options);
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
        return '[Twilio.Insights.V1.CallSummaryInstance ' . implode(' ', $context) . ']';
    }
}