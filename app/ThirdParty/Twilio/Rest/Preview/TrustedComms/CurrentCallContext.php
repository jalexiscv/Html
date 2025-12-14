<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;

class CurrentCallContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/CurrentCall';
    }

    public function fetch(array $options = []): CurrentCallInstance
    {
        $options = new Values($options);
        $headers = Values::of(['X-Xcnam-Sensitive-Phone-Number-From' => $options['xXcnamSensitivePhoneNumberFrom'], 'X-Xcnam-Sensitive-Phone-Number-To' => $options['xXcnamSensitivePhoneNumberTo'],]);
        $payload = $this->version->fetch('GET', $this->uri, [], [], $headers);
        return new CurrentCallInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.TrustedComms.CurrentCallContext ' . implode(' ', $context) . ']';
    }
}