<?php

namespace Twilio\Rest\Pricing\V1\Voice;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class NumberContext extends InstanceContext
{
    public function __construct(Version $version, $number)
    {
        parent::__construct($version);
        $this->solution = ['number' => $number,];
        $this->uri = '/Voice/Numbers/' . rawurlencode($number) . '';
    }

    public function fetch(): NumberInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new NumberInstance($this->version, $payload, $this->solution['number']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Pricing.V1.NumberContext ' . implode(' ', $context) . ']';
    }
}