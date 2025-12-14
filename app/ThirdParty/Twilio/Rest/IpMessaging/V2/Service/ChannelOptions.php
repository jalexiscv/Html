<?php

namespace Twilio\Rest\IpMessaging\V2\Service;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ChannelOptions
{
    public static function delete(string $xTwilioWebhookEnabled = Values::NONE): DeleteChannelOptions
    {
        return new DeleteChannelOptions($xTwilioWebhookEnabled);
    }

    public static function create(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE, string $type = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $createdBy = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateChannelOptions
    {
        return new CreateChannelOptions($friendlyName, $uniqueName, $attributes, $type, $dateCreated, $dateUpdated, $createdBy, $xTwilioWebhookEnabled);
    }

    public static function read(array $type = Values::ARRAY_NONE): ReadChannelOptions
    {
        return new ReadChannelOptions($type);
    }

    public static function update(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $createdBy = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateChannelOptions
    {
        return new UpdateChannelOptions($friendlyName, $uniqueName, $attributes, $dateCreated, $dateUpdated, $createdBy, $xTwilioWebhookEnabled);
    }
}

class DeleteChannelOptions extends Options
{
    public function __construct(string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V2.DeleteChannelOptions ' . $options . ']';
    }
}

class CreateChannelOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE, string $type = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $createdBy = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['attributes'] = $attributes;
        $this->options['type'] = $type;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['createdBy'] = $createdBy;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setType(string $type): self
    {
        $this->options['type'] = $type;
        return $this;
    }

    public function setDateCreated(DateTime $dateCreated): self
    {
        $this->options['dateCreated'] = $dateCreated;
        return $this;
    }

    public function setDateUpdated(DateTime $dateUpdated): self
    {
        $this->options['dateUpdated'] = $dateUpdated;
        return $this;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->options['createdBy'] = $createdBy;
        return $this;
    }

    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V2.CreateChannelOptions ' . $options . ']';
    }
}

class ReadChannelOptions extends Options
{
    public function __construct(array $type = Values::ARRAY_NONE)
    {
        $this->options['type'] = $type;
    }

    public function setType(array $type): self
    {
        $this->options['type'] = $type;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V2.ReadChannelOptions ' . $options . ']';
    }
}

class UpdateChannelOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $createdBy = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['attributes'] = $attributes;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['createdBy'] = $createdBy;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setDateCreated(DateTime $dateCreated): self
    {
        $this->options['dateCreated'] = $dateCreated;
        return $this;
    }

    public function setDateUpdated(DateTime $dateUpdated): self
    {
        $this->options['dateUpdated'] = $dateUpdated;
        return $this;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->options['createdBy'] = $createdBy;
        return $this;
    }

    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V2.UpdateChannelOptions ' . $options . ']';
    }
}