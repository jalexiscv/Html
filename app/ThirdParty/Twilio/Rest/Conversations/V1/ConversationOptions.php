<?php

namespace Twilio\Rest\Conversations\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConversationOptions
{
    public static function create(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $messagingServiceSid = Values::NONE, string $attributes = Values::NONE, string $state = Values::NONE, string $timersInactive = Values::NONE, string $timersClosed = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateConversationOptions
    {
        return new CreateConversationOptions($friendlyName, $uniqueName, $dateCreated, $dateUpdated, $messagingServiceSid, $attributes, $state, $timersInactive, $timersClosed, $xTwilioWebhookEnabled);
    }

    public static function update(string $friendlyName = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $messagingServiceSid = Values::NONE, string $state = Values::NONE, string $timersInactive = Values::NONE, string $timersClosed = Values::NONE, string $uniqueName = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateConversationOptions
    {
        return new UpdateConversationOptions($friendlyName, $dateCreated, $dateUpdated, $attributes, $messagingServiceSid, $state, $timersInactive, $timersClosed, $uniqueName, $xTwilioWebhookEnabled);
    }

    public static function delete(string $xTwilioWebhookEnabled = Values::NONE): DeleteConversationOptions
    {
        return new DeleteConversationOptions($xTwilioWebhookEnabled);
    }
}

class CreateConversationOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $messagingServiceSid = Values::NONE, string $attributes = Values::NONE, string $state = Values::NONE, string $timersInactive = Values::NONE, string $timersClosed = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        $this->options['attributes'] = $attributes;
        $this->options['state'] = $state;
        $this->options['timersInactive'] = $timersInactive;
        $this->options['timersClosed'] = $timersClosed;
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

    public function setMessagingServiceSid(string $messagingServiceSid): self
    {
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setState(string $state): self
    {
        $this->options['state'] = $state;
        return $this;
    }

    public function setTimersInactive(string $timersInactive): self
    {
        $this->options['timersInactive'] = $timersInactive;
        return $this;
    }

    public function setTimersClosed(string $timersClosed): self
    {
        $this->options['timersClosed'] = $timersClosed;
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
        return '[Twilio.Conversations.V1.CreateConversationOptions ' . $options . ']';
    }
}

class UpdateConversationOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $messagingServiceSid = Values::NONE, string $state = Values::NONE, string $timersInactive = Values::NONE, string $timersClosed = Values::NONE, string $uniqueName = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['attributes'] = $attributes;
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        $this->options['state'] = $state;
        $this->options['timersInactive'] = $timersInactive;
        $this->options['timersClosed'] = $timersClosed;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
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

    public function setMessagingServiceSid(string $messagingServiceSid): self
    {
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        return $this;
    }

    public function setState(string $state): self
    {
        $this->options['state'] = $state;
        return $this;
    }

    public function setTimersInactive(string $timersInactive): self
    {
        $this->options['timersInactive'] = $timersInactive;
        return $this;
    }

    public function setTimersClosed(string $timersClosed): self
    {
        $this->options['timersClosed'] = $timersClosed;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
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
        return '[Twilio.Conversations.V1.UpdateConversationOptions ' . $options . ']';
    }
}

class DeleteConversationOptions extends Options
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
        return '[Twilio.Conversations.V1.DeleteConversationOptions ' . $options . ']';
    }
}