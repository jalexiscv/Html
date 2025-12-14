<?php

namespace Twilio\Rest\Preview\TrustedComms;

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

class CurrentCallInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['bgColor' => Values::array_get($payload, 'bg_color'), 'caller' => Values::array_get($payload, 'caller'), 'createdAt' => Deserialize::dateTime(Values::array_get($payload, 'created_at')), 'fontColor' => Values::array_get($payload, 'font_color'), 'from' => Values::array_get($payload, 'from'), 'logo' => Values::array_get($payload, 'logo'), 'manager' => Values::array_get($payload, 'manager'), 'reason' => Values::array_get($payload, 'reason'), 'shieldImg' => Values::array_get($payload, 'shield_img'), 'sid' => Values::array_get($payload, 'sid'), 'status' => Values::array_get($payload, 'status'), 'to' => Values::array_get($payload, 'to'), 'url' => Values::array_get($payload, 'url'), 'useCase' => Values::array_get($payload, 'use_case'),];
        $this->solution = [];
    }

    protected function proxy(): CurrentCallContext
    {
        if (!$this->context) {
            $this->context = new CurrentCallContext($this->version);
        }
        return $this->context;
    }

    public function fetch(array $options = []): CurrentCallInstance
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
        return '[Twilio.Preview.TrustedComms.CurrentCallInstance ' . implode(' ', $context) . ']';
    }
}