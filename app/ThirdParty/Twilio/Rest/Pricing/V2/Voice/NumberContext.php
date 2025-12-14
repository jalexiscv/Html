<?php

namespace Twilio\Rest\Pricing\V2\Voice;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class NumberContext extends InstanceContext
{
    public function __construct(Version $version, $destinationNumber)
    {
        parent::__construct($version);
        $this->solution = ['destinationNumber' => $destinationNumber,];
        $this->uri = '/Voice/Numbers/' . rawurlencode($destinationNumber) . '';
    }

    public function fetch(array $options = []): NumberInstance
    {
        $options = new Values($options);
        $params = Values::of(['OriginationNumber' => $options['originationNumber'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new NumberInstance($this->version, $payload, $this->solution['destinationNumber']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Pricing.V2.NumberContext ' . implode(' ', $context) . ']';
    }
}