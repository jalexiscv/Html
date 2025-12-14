<?php

namespace Twilio\Rest\Pricing\V2\Voice;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CountryInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $isoCountry = null)
    {
        parent::__construct($version);
        $this->properties = ['country' => Values::array_get($payload, 'country'), 'isoCountry' => Values::array_get($payload, 'iso_country'), 'outboundPrefixPrices' => Values::array_get($payload, 'outbound_prefix_prices'), 'inboundCallPrices' => Values::array_get($payload, 'inbound_call_prices'), 'priceUnit' => Values::array_get($payload, 'price_unit'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['isoCountry' => $isoCountry ?: $this->properties['isoCountry'],];
    }

    protected function proxy(): CountryContext
    {
        if (!$this->context) {
            $this->context = new CountryContext($this->version, $this->solution['isoCountry']);
        }
        return $this->context;
    }

    public function fetch(): CountryInstance
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
        return '[Twilio.Pricing.V2.CountryInstance ' . implode(' ', $context) . ']';
    }
}