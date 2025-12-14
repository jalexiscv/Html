<?php

namespace Twilio\Rest\Pricing\V2\Voice;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class CountryContext extends InstanceContext
{
    public function __construct(Version $version, $isoCountry)
    {
        parent::__construct($version);
        $this->solution = ['isoCountry' => $isoCountry,];
        $this->uri = '/Voice/Countries/' . rawurlencode($isoCountry) . '';
    }

    public function fetch(): CountryInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CountryInstance($this->version, $payload, $this->solution['isoCountry']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Pricing.V2.CountryContext ' . implode(' ', $context) . ']';
    }
}