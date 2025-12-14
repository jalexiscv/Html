<?php

namespace Twilio\Rest\Supersim\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class UsageRecordOptions
{
    public static function read(string $sim = Values::NONE, string $fleet = Values::NONE, string $network = Values::NONE, string $isoCountry = Values::NONE, string $group = Values::NONE, string $granularity = Values::NONE, DateTime $startTime = Values::NONE, DateTime $endTime = Values::NONE): ReadUsageRecordOptions
    {
        return new ReadUsageRecordOptions($sim, $fleet, $network, $isoCountry, $group, $granularity, $startTime, $endTime);
    }
}

class ReadUsageRecordOptions extends Options
{
    public function __construct(string $sim = Values::NONE, string $fleet = Values::NONE, string $network = Values::NONE, string $isoCountry = Values::NONE, string $group = Values::NONE, string $granularity = Values::NONE, DateTime $startTime = Values::NONE, DateTime $endTime = Values::NONE)
    {
        $this->options['sim'] = $sim;
        $this->options['fleet'] = $fleet;
        $this->options['network'] = $network;
        $this->options['isoCountry'] = $isoCountry;
        $this->options['group'] = $group;
        $this->options['granularity'] = $granularity;
        $this->options['startTime'] = $startTime;
        $this->options['endTime'] = $endTime;
    }

    public function setSim(string $sim): self
    {
        $this->options['sim'] = $sim;
        return $this;
    }

    public function setFleet(string $fleet): self
    {
        $this->options['fleet'] = $fleet;
        return $this;
    }

    public function setNetwork(string $network): self
    {
        $this->options['network'] = $network;
        return $this;
    }

    public function setIsoCountry(string $isoCountry): self
    {
        $this->options['isoCountry'] = $isoCountry;
        return $this;
    }

    public function setGroup(string $group): self
    {
        $this->options['group'] = $group;
        return $this;
    }

    public function setGranularity(string $granularity): self
    {
        $this->options['granularity'] = $granularity;
        return $this;
    }

    public function setStartTime(DateTime $startTime): self
    {
        $this->options['startTime'] = $startTime;
        return $this;
    }

    public function setEndTime(DateTime $endTime): self
    {
        $this->options['endTime'] = $endTime;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.ReadUsageRecordOptions ' . $options . ']';
    }
}