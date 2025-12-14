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

class BrandsInformationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['updateTime' => Deserialize::dateTime(Values::array_get($payload, 'update_time')), 'fileLink' => Values::array_get($payload, 'file_link'), 'fileLinkTtlInSeconds' => Values::array_get($payload, 'file_link_ttl_in_seconds'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = [];
    }

    protected function proxy(): BrandsInformationContext
    {
        if (!$this->context) {
            $this->context = new BrandsInformationContext($this->version);
        }
        return $this->context;
    }

    public function fetch(array $options = []): BrandsInformationInstance
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
        return '[Twilio.Preview.TrustedComms.BrandsInformationInstance ' . implode(' ', $context) . ']';
    }
}