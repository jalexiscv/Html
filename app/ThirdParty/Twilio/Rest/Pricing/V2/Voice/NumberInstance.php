<?php

namespace Twilio\Rest\Pricing\V2\Voice;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class NumberInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $destinationNumber = null)
    {
        parent::__construct($version);
        $this->properties = ['destinationNumber' => Values::array_get($payload, 'destination_number'), 'originationNumber' => Values::array_get($payload, 'origination_number'), 'country' => Values::array_get($payload, 'country'), 'isoCountry' => Values::array_get($payload, 'iso_country'), 'outboundCallPrices' => Values::array_get($payload, 'outbound_call_prices'), 'inboundCallPrice' => Values::array_get($payload, 'inbound_call_price'), 'priceUnit' => Values::array_get($payload, 'price_unit'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['destinationNumber' => $destinationNumber ?: $this->properties['destinationNumber'],];
    }

    protected function proxy(): NumberContext
    {
        if (!$this->context) {
            $this->context = new NumberContext($this->version, $this->solution['destinationNumber']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): NumberInstance
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
        return '[Twilio.Pricing.V2.NumberInstance ' . implode(' ', $context) . ']';
    }
}