<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MessageOptions
{
    public static function create(string $from = Values::NONE, string $attributes = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $lastUpdatedBy = Values::NONE, string $body = Values::NONE, string $mediaSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateMessageOptions
    {
        return new CreateMessageOptions($from, $attributes, $dateCreated, $dateUpdated, $lastUpdatedBy, $body, $mediaSid, $xTwilioWebhookEnabled);
    }

    public static function read(string $order = Values::NONE): ReadMessageOptions
    {
        return new ReadMessageOptions($order);
    }

    public static function delete(string $xTwilioWebhookEnabled = Values::NONE): DeleteMessageOptions
    {
        return new DeleteMessageOptions($xTwilioWebhookEnabled);
    }

    public static function update(string $body = Values::NONE, string $attributes = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $lastUpdatedBy = Values::NONE, string $from = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateMessageOptions
    {
        return new UpdateMessageOptions($body, $attributes, $dateCreated, $dateUpdated, $lastUpdatedBy, $from, $xTwilioWebhookEnabled);
    }
}

class CreateMessageOptions extends Options
{
    public function __construct(string $from = Values::NONE, string $attributes = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $lastUpdatedBy = Values::NONE, string $body = Values::NONE, string $mediaSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['from'] = $from;
        $this->options['attributes'] = $attributes;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['lastUpdatedBy'] = $lastUpdatedBy;
        $this->options['body'] = $body;
        $this->options['mediaSid'] = $mediaSid;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
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

    public function setLastUpdatedBy(string $lastUpdatedBy): self
    {
        $this->options['lastUpdatedBy'] = $lastUpdatedBy;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
        return $this;
    }

    public function setMediaSid(string $mediaSid): self
    {
        $this->options['mediaSid'] = $mediaSid;
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
        return '[Twilio.Chat.V2.CreateMessageOptions ' . $options . ']';
    }
}

class ReadMessageOptions extends Options
{
    public function __construct(string $order = Values::NONE)
    {
        $this->options['order'] = $order;
    }

    public function setOrder(string $order): self
    {
        $this->options['order'] = $order;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.ReadMessageOptions ' . $options . ']';
    }
}

class DeleteMessageOptions extends Options
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
        return '[Twilio.Chat.V2.DeleteMessageOptions ' . $options . ']';
    }
}

class UpdateMessageOptions extends Options
{
    public function __construct(string $body = Values::NONE, string $attributes = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $lastUpdatedBy = Values::NONE, string $from = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['body'] = $body;
        $this->options['attributes'] = $attributes;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['lastUpdatedBy'] = $lastUpdatedBy;
        $this->options['from'] = $from;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
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

    public function setLastUpdatedBy(string $lastUpdatedBy): self
    {
        $this->options['lastUpdatedBy'] = $lastUpdatedBy;
        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
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
        return '[Twilio.Chat.V2.UpdateMessageOptions ' . $options . ']';
    }
}