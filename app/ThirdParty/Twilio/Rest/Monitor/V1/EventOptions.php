<?php

namespace Twilio\Rest\Monitor\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class EventOptions
{
    public static function read(string $actorSid = Values::NONE, string $eventType = Values::NONE, string $resourceSid = Values::NONE, string $sourceIpAddress = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE): ReadEventOptions
    {
        return new ReadEventOptions($actorSid, $eventType, $resourceSid, $sourceIpAddress, $startDate, $endDate);
    }
}

class ReadEventOptions extends Options
{
    public function __construct(string $actorSid = Values::NONE, string $eventType = Values::NONE, string $resourceSid = Values::NONE, string $sourceIpAddress = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE)
    {
        $this->options['actorSid'] = $actorSid;
        $this->options['eventType'] = $eventType;
        $this->options['resourceSid'] = $resourceSid;
        $this->options['sourceIpAddress'] = $sourceIpAddress;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
    }

    public function setActorSid(string $actorSid): self
    {
        $this->options['actorSid'] = $actorSid;
        return $this;
    }

    public function setEventType(string $eventType): self
    {
        $this->options['eventType'] = $eventType;
        return $this;
    }

    public function setResourceSid(string $resourceSid): self
    {
        $this->options['resourceSid'] = $resourceSid;
        return $this;
    }

    public function setSourceIpAddress(string $sourceIpAddress): self
    {
        $this->options['sourceIpAddress'] = $sourceIpAddress;
        return $this;
    }

    public function setStartDate(DateTime $startDate): self
    {
        $this->options['startDate'] = $startDate;
        return $this;
    }

    public function setEndDate(DateTime $endDate): self
    {
        $this->options['endDate'] = $endDate;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Monitor.V1.ReadEventOptions ' . $options . ']';
    }
}