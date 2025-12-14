<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Insights;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ImpressionsRateOptions
{
    public static function fetch(string $brandSid = Values::NONE, string $brandedChannelSid = Values::NONE, string $phoneNumberSid = Values::NONE, string $country = Values::NONE, DateTime $start = Values::NONE, DateTime $end = Values::NONE, string $interval = Values::NONE): FetchImpressionsRateOptions
    {
        return new FetchImpressionsRateOptions($brandSid, $brandedChannelSid, $phoneNumberSid, $country, $start, $end, $interval);
    }
}

class FetchImpressionsRateOptions extends Options
{
    public function __construct(string $brandSid = Values::NONE, string $brandedChannelSid = Values::NONE, string $phoneNumberSid = Values::NONE, string $country = Values::NONE, DateTime $start = Values::NONE, DateTime $end = Values::NONE, string $interval = Values::NONE)
    {
        $this->options['brandSid'] = $brandSid;
        $this->options['brandedChannelSid'] = $brandedChannelSid;
        $this->options['phoneNumberSid'] = $phoneNumberSid;
        $this->options['country'] = $country;
        $this->options['start'] = $start;
        $this->options['end'] = $end;
        $this->options['interval'] = $interval;
    }

    public function setBrandSid(string $brandSid): self
    {
        $this->options['brandSid'] = $brandSid;
        return $this;
    }

    public function setBrandedChannelSid(string $brandedChannelSid): self
    {
        $this->options['brandedChannelSid'] = $brandedChannelSid;
        return $this;
    }

    public function setPhoneNumberSid(string $phoneNumberSid): self
    {
        $this->options['phoneNumberSid'] = $phoneNumberSid;
        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->options['country'] = $country;
        return $this;
    }

    public function setStart(DateTime $start): self
    {
        $this->options['start'] = $start;
        return $this;
    }

    public function setEnd(DateTime $end): self
    {
        $this->options['end'] = $end;
        return $this;
    }

    public function setInterval(string $interval): self
    {
        $this->options['interval'] = $interval;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.TrustedComms.FetchImpressionsRateOptions ' . $options . ']';
    }
}