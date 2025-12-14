<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConferenceOptions
{
    public static function read(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE, string $dateUpdatedBefore = Values::NONE, string $dateUpdated = Values::NONE, string $dateUpdatedAfter = Values::NONE, string $friendlyName = Values::NONE, string $status = Values::NONE): ReadConferenceOptions
    {
        return new ReadConferenceOptions($dateCreatedBefore, $dateCreated, $dateCreatedAfter, $dateUpdatedBefore, $dateUpdated, $dateUpdatedAfter, $friendlyName, $status);
    }

    public static function update(string $status = Values::NONE, string $announceUrl = Values::NONE, string $announceMethod = Values::NONE): UpdateConferenceOptions
    {
        return new UpdateConferenceOptions($status, $announceUrl, $announceMethod);
    }
}

class ReadConferenceOptions extends Options
{
    public function __construct(string $dateCreatedBefore = Values::NONE, string $dateCreated = Values::NONE, string $dateCreatedAfter = Values::NONE, string $dateUpdatedBefore = Values::NONE, string $dateUpdated = Values::NONE, string $dateUpdatedAfter = Values::NONE, string $friendlyName = Values::NONE, string $status = Values::NONE)
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['dateUpdatedBefore'] = $dateUpdatedBefore;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['dateUpdatedAfter'] = $dateUpdatedAfter;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['status'] = $status;
    }

    public function setDateCreatedBefore(string $dateCreatedBefore): self
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        return $this;
    }

    public function setDateCreated(string $dateCreated): self
    {
        $this->options['dateCreated'] = $dateCreated;
        return $this;
    }

    public function setDateCreatedAfter(string $dateCreatedAfter): self
    {
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        return $this;
    }

    public function setDateUpdatedBefore(string $dateUpdatedBefore): self
    {
        $this->options['dateUpdatedBefore'] = $dateUpdatedBefore;
        return $this;
    }

    public function setDateUpdated(string $dateUpdated): self
    {
        $this->options['dateUpdated'] = $dateUpdated;
        return $this;
    }

    public function setDateUpdatedAfter(string $dateUpdatedAfter): self
    {
        $this->options['dateUpdatedAfter'] = $dateUpdatedAfter;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadConferenceOptions ' . $options . ']';
    }
}

class UpdateConferenceOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $announceUrl = Values::NONE, string $announceMethod = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['announceUrl'] = $announceUrl;
        $this->options['announceMethod'] = $announceMethod;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setAnnounceUrl(string $announceUrl): self
    {
        $this->options['announceUrl'] = $announceUrl;
        return $this;
    }

    public function setAnnounceMethod(string $announceMethod): self
    {
        $this->options['announceMethod'] = $announceMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateConferenceOptions ' . $options . ']';
    }
}