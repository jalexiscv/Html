<?php

namespace Twilio\Rest\Conversations\V1\Service\Configuration;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class NotificationOptions
{
    public static function update(bool $logEnabled = Values::NONE, bool $newMessageEnabled = Values::NONE, string $newMessageTemplate = Values::NONE, string $newMessageSound = Values::NONE, bool $newMessageBadgeCountEnabled = Values::NONE, bool $addedToConversationEnabled = Values::NONE, string $addedToConversationTemplate = Values::NONE, string $addedToConversationSound = Values::NONE, bool $removedFromConversationEnabled = Values::NONE, string $removedFromConversationTemplate = Values::NONE, string $removedFromConversationSound = Values::NONE): UpdateNotificationOptions
    {
        return new UpdateNotificationOptions($logEnabled, $newMessageEnabled, $newMessageTemplate, $newMessageSound, $newMessageBadgeCountEnabled, $addedToConversationEnabled, $addedToConversationTemplate, $addedToConversationSound, $removedFromConversationEnabled, $removedFromConversationTemplate, $removedFromConversationSound);
    }
}

class UpdateNotificationOptions extends Options
{
    public function __construct(bool $logEnabled = Values::NONE, bool $newMessageEnabled = Values::NONE, string $newMessageTemplate = Values::NONE, string $newMessageSound = Values::NONE, bool $newMessageBadgeCountEnabled = Values::NONE, bool $addedToConversationEnabled = Values::NONE, string $addedToConversationTemplate = Values::NONE, string $addedToConversationSound = Values::NONE, bool $removedFromConversationEnabled = Values::NONE, string $removedFromConversationTemplate = Values::NONE, string $removedFromConversationSound = Values::NONE)
    {
        $this->options['logEnabled'] = $logEnabled;
        $this->options['newMessageEnabled'] = $newMessageEnabled;
        $this->options['newMessageTemplate'] = $newMessageTemplate;
        $this->options['newMessageSound'] = $newMessageSound;
        $this->options['newMessageBadgeCountEnabled'] = $newMessageBadgeCountEnabled;
        $this->options['addedToConversationEnabled'] = $addedToConversationEnabled;
        $this->options['addedToConversationTemplate'] = $addedToConversationTemplate;
        $this->options['addedToConversationSound'] = $addedToConversationSound;
        $this->options['removedFromConversationEnabled'] = $removedFromConversationEnabled;
        $this->options['removedFromConversationTemplate'] = $removedFromConversationTemplate;
        $this->options['removedFromConversationSound'] = $removedFromConversationSound;
    }

    public function setLogEnabled(bool $logEnabled): self
    {
        $this->options['logEnabled'] = $logEnabled;
        return $this;
    }

    public function setNewMessageEnabled(bool $newMessageEnabled): self
    {
        $this->options['newMessageEnabled'] = $newMessageEnabled;
        return $this;
    }

    public function setNewMessageTemplate(string $newMessageTemplate): self
    {
        $this->options['newMessageTemplate'] = $newMessageTemplate;
        return $this;
    }

    public function setNewMessageSound(string $newMessageSound): self
    {
        $this->options['newMessageSound'] = $newMessageSound;
        return $this;
    }

    public function setNewMessageBadgeCountEnabled(bool $newMessageBadgeCountEnabled): self
    {
        $this->options['newMessageBadgeCountEnabled'] = $newMessageBadgeCountEnabled;
        return $this;
    }

    public function setAddedToConversationEnabled(bool $addedToConversationEnabled): self
    {
        $this->options['addedToConversationEnabled'] = $addedToConversationEnabled;
        return $this;
    }

    public function setAddedToConversationTemplate(string $addedToConversationTemplate): self
    {
        $this->options['addedToConversationTemplate'] = $addedToConversationTemplate;
        return $this;
    }

    public function setAddedToConversationSound(string $addedToConversationSound): self
    {
        $this->options['addedToConversationSound'] = $addedToConversationSound;
        return $this;
    }

    public function setRemovedFromConversationEnabled(bool $removedFromConversationEnabled): self
    {
        $this->options['removedFromConversationEnabled'] = $removedFromConversationEnabled;
        return $this;
    }

    public function setRemovedFromConversationTemplate(string $removedFromConversationTemplate): self
    {
        $this->options['removedFromConversationTemplate'] = $removedFromConversationTemplate;
        return $this;
    }

    public function setRemovedFromConversationSound(string $removedFromConversationSound): self
    {
        $this->options['removedFromConversationSound'] = $removedFromConversationSound;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.UpdateNotificationOptions ' . $options . ']';
    }
}