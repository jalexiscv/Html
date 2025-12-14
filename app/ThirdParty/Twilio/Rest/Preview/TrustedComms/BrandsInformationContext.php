<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;

class BrandsInformationContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/BrandsInformation';
    }

    public function fetch(array $options = []): BrandsInformationInstance
    {
        $options = new Values($options);
        $headers = Values::of(['If-None-Match' => $options['ifNoneMatch'],]);
        $payload = $this->version->fetch('GET', $this->uri, [], [], $headers);
        return new BrandsInformationInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.TrustedComms.BrandsInformationContext ' . implode(' ', $context) . ']';
    }
}