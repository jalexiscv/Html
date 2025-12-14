<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;

class CpsContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/CPS';
    }

    public function fetch(array $options = []): CpsInstance
    {
        $options = new Values($options);
        $headers = Values::of(['X-Xcnam-Sensitive-Phone-Number' => $options['xXcnamSensitivePhoneNumber'],]);
        $payload = $this->version->fetch('GET', $this->uri, [], [], $headers);
        return new CpsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.TrustedComms.CpsContext ' . implode(' ', $context) . ']';
    }
}