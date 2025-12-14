<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Insights;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ImpressionsRateContext extends InstanceContext
{
    public function __construct(Version $version, $businessSid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid,];
        $this->uri = '/Businesses/' . rawurlencode($businessSid) . '/Insights/ImpressionsRate';
    }

    public function fetch(array $options = []): ImpressionsRateInstance
    {
        $options = new Values($options);
        $params = Values::of(['BrandSid' => $options['brandSid'], 'BrandedChannelSid' => $options['brandedChannelSid'], 'PhoneNumberSid' => $options['phoneNumberSid'], 'Country' => $options['country'], 'Start' => Serialize::iso8601DateTime($options['start']), 'End' => Serialize::iso8601DateTime($options['end']), 'Interval' => $options['interval'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new ImpressionsRateInstance($this->version, $payload, $this->solution['businessSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.TrustedComms.ImpressionsRateContext ' . implode(' ', $context) . ']';
    }
}