<?php

namespace Twilio\Rest\Conversations\V1\Service\Conversation;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MessageOptions
{
    public static function create(string $author = Values::NONE, string $body = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $mediaSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateMessageOptions
    {
        return new CreateMessageOptions($author, $body, $dateCreated, $dateUpdated, $attributes, $mediaSid, $xTwilioWebhookEnabled);
    }

    public static function update(string $author = Values::NONE, string $body = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateMessageOptions
    {
        return new UpdateMessageOptions($author, $body, $dateCreated, $dateUpdated, $attributes, $xTwilioWebhookEnabled);
    }

    public static function delete(string $xTwilioWebhookEnabled = Values::NONE): DeleteMessageOptions
    {
        return new DeleteMessageOptions($xTwilioWebhookEnabled);
    }
}

class CreateMessageOptions extends Options
{
    public function __construct(string $author = Values::NONE, string $body = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $mediaSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['author'] = $author;
        $this->options['body'] = $body;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['attributes'] = $attributes;
        $this->options['mediaSid'] = $mediaSid;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setAuthor(string $author): self
    {
        $this->options['author'] = $author;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
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

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
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
        return '[Twilio.Conversations.V1.CreateMessageOptions ' . $options . ']';
    }
}

class UpdateMessageOptions extends Options
{
    public function __construct(string $author = Values::NONE, string $body = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['author'] = $author;
        $this->options['body'] = $body;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['attributes'] = $attributes;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setAuthor(string $author): self
    {
        $this->options['author'] = $author;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
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

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
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
        return '[Twilio.Conversations.V1.UpdateMessageOptions ' . $options . ']';
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
        return '[Twilio.Conversations.V1.DeleteMessageOptions ' . $options . ']';
    }
}