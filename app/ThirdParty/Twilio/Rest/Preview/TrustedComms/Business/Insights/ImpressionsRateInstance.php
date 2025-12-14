<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Insights;

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

class ImpressionsRateInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $businessSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'businessSid' => Values::array_get($payload, 'business_sid'), 'end' => Deserialize::dateTime(Values::array_get($payload, 'end')), 'interval' => Values::array_get($payload, 'interval'), 'reports' => Values::array_get($payload, 'reports'), 'start' => Deserialize::dateTime(Values::array_get($payload, 'start')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['businessSid' => $businessSid,];
    }

    protected function proxy(): ImpressionsRateContext
    {
        if (!$this->context) {
            $this->context = new ImpressionsRateContext($this->version, $this->solution['businessSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): ImpressionsRateInstance
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
        return '[Twilio.Preview.TrustedComms.ImpressionsRateInstance ' . implode(' ', $context) . ']';
    }
}