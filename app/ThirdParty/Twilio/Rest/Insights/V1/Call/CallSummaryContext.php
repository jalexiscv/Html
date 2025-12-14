<?php

namespace Twilio\Rest\Insights\V1\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class CallSummaryContext extends InstanceContext
{
    public function __construct(Version $version, $callSid)
    {
        parent::__construct($version);
        $this->solution = ['callSid' => $callSid,];
        $this->uri = '/Voice/' . rawurlencode($callSid) . '/Summary';
    }

    public function fetch(array $options = []): CallSummaryInstance
    {
        $options = new Values($options);
        $params = Values::of(['ProcessingState' => $options['processingState'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new CallSummaryInstance($this->version, $payload, $this->solution['callSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Insights.V1.CallSummaryContext ' . implode(' ', $context) . ']';
    }
}