<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

class BrandedCallList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Business/BrandedCalls';
    }

    public function create(string $from, string $to, string $reason, array $options = []): BrandedCallInstance
    {
        $options = new Values($options);
        $data = Values::of(['From' => $from, 'To' => $to, 'Reason' => $reason, 'CallSid' => $options['callSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new BrandedCallInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.BrandedCallList]';
    }
}