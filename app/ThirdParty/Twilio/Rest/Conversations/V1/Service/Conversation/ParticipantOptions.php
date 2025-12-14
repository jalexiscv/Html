<?php

namespace Twilio\Rest\Conversations\V1\Service\Conversation;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ParticipantOptions
{
    public static function create(string $identity = Values::NONE, string $messagingBindingAddress = Values::NONE, string $messagingBindingProxyAddress = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $messagingBindingProjectedAddress = Values::NONE, string $roleSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateParticipantOptions
    {
        return new CreateParticipantOptions($identity, $messagingBindingAddress, $messagingBindingProxyAddress, $dateCreated, $dateUpdated, $attributes, $messagingBindingProjectedAddress, $roleSid, $xTwilioWebhookEnabled);
    }

    public static function update(DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $identity = Values::NONE, string $attributes = Values::NONE, string $roleSid = Values::NONE, string $messagingBindingProxyAddress = Values::NONE, string $messagingBindingProjectedAddress = Values::NONE, int $lastReadMessageIndex = Values::NONE, string $lastReadTimestamp = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateParticipantOptions
    {
        return new UpdateParticipantOptions($dateCreated, $dateUpdated, $identity, $attributes, $roleSid, $messagingBindingProxyAddress, $messagingBindingProjectedAddress, $lastReadMessageIndex, $lastReadTimestamp, $xTwilioWebhookEnabled);
    }

    public static function delete(string $xTwilioWebhookEnabled = Values::NONE): DeleteParticipantOptions
    {
        return new DeleteParticipantOptions($xTwilioWebhookEnabled);
    }
}

class CreateParticipantOptions extends Options
{
    public function __construct(string $identity = Values::NONE, string $messagingBindingAddress = Values::NONE, string $messagingBindingProxyAddress = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $messagingBindingProjectedAddress = Values::NONE, string $roleSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['identity'] = $identity;
        $this->options['messagingBindingAddress'] = $messagingBindingAddress;
        $this->options['messagingBindingProxyAddress'] = $messagingBindingProxyAddress;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['attributes'] = $attributes;
        $this->options['messagingBindingProjectedAddress'] = $messagingBindingProjectedAddress;
        $this->options['roleSid'] = $roleSid;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setIdentity(string $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function setMessagingBindingAddress(string $messagingBindingAddress): self
    {
        $this->options['messagingBindingAddress'] = $messagingBindingAddress;
        return $this;
    }

    public function setMessagingBindingProxyAddress(string $messagingBindingProxyAddress): self
    {
        $this->options['messagingBindingProxyAddress'] = $messagingBindingProxyAddress;
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

    public function setMessagingBindingProjectedAddress(string $messagingBindingProjectedAddress): self
    {
        $this->options['messagingBindingProjectedAddress'] = $messagingBindingProjectedAddress;
        return $this;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
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
        return '[Twilio.Conversations.V1.CreateParticipantOptions ' . $options . ']';
    }
}

class UpdateParticipantOptions extends Options
{
    public function __construct(DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $identity = Values::NONE, string $attributes = Values::NONE, string $roleSid = Values::NONE, string $messagingBindingProxyAddress = Values::NONE, string $messagingBindingProjectedAddress = Values::NONE, int $lastReadMessageIndex = Values::NONE, string $lastReadTimestamp = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['identity'] = $identity;
        $this->options['attributes'] = $attributes;
        $this->options['roleSid'] = $roleSid;
        $this->options['messagingBindingProxyAddress'] = $messagingBindingProxyAddress;
        $this->options['messagingBindingProjectedAddress'] = $messagingBindingProjectedAddress;
        $this->options['lastReadMessageIndex'] = $lastReadMessageIndex;
        $this->options['lastReadTimestamp'] = $lastReadTimestamp;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
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

    public function setIdentity(string $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setMessagingBindingProxyAddress(string $messagingBindingProxyAddress): self
    {
        $this->options['messagingBindingProxyAddress'] = $messagingBindingProxyAddress;
        return $this;
    }

    public function setMessagingBindingProjectedAddress(string $messagingBindingProjectedAddress): self
    {
        $this->options['messagingBindingProjectedAddress'] = $messagingBindingProjectedAddress;
        return $this;
    }

    public function setLastReadMessageIndex(int $lastReadMessageIndex): self
    {
        $this->options['lastReadMessageIndex'] = $lastReadMessageIndex;
        return $this;
    }

    public function setLastReadTimestamp(string $lastReadTimestamp): self
    {
        $this->options['lastReadTimestamp'] = $lastReadTimestamp;
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
        return '[Twilio.Conversations.V1.UpdateParticipantOptions ' . $options . ']';
    }
}

class DeleteParticipantOptions extends Options
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
        return '[Twilio.Conversations.V1.DeleteParticipantOptions ' . $options . ']';
    }
}