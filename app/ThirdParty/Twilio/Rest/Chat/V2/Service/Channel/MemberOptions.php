<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MemberOptions
{
    public static function create(string $roleSid = Values::NONE, int $lastConsumedMessageIndex = Values::NONE, DateTime $lastConsumptionTimestamp = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateMemberOptions
    {
        return new CreateMemberOptions($roleSid, $lastConsumedMessageIndex, $lastConsumptionTimestamp, $dateCreated, $dateUpdated, $attributes, $xTwilioWebhookEnabled);
    }

    public static function read(array $identity = Values::ARRAY_NONE): ReadMemberOptions
    {
        return new ReadMemberOptions($identity);
    }

    public static function delete(string $xTwilioWebhookEnabled = Values::NONE): DeleteMemberOptions
    {
        return new DeleteMemberOptions($xTwilioWebhookEnabled);
    }

    public static function update(string $roleSid = Values::NONE, int $lastConsumedMessageIndex = Values::NONE, DateTime $lastConsumptionTimestamp = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateMemberOptions
    {
        return new UpdateMemberOptions($roleSid, $lastConsumedMessageIndex, $lastConsumptionTimestamp, $dateCreated, $dateUpdated, $attributes, $xTwilioWebhookEnabled);
    }
}

class CreateMemberOptions extends Options
{
    public function __construct(string $roleSid = Values::NONE, int $lastConsumedMessageIndex = Values::NONE, DateTime $lastConsumptionTimestamp = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
        $this->options['lastConsumedMessageIndex'] = $lastConsumedMessageIndex;
        $this->options['lastConsumptionTimestamp'] = $lastConsumptionTimestamp;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['attributes'] = $attributes;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setLastConsumedMessageIndex(int $lastConsumedMessageIndex): self
    {
        $this->options['lastConsumedMessageIndex'] = $lastConsumedMessageIndex;
        return $this;
    }

    public function setLastConsumptionTimestamp(DateTime $lastConsumptionTimestamp): self
    {
        $this->options['lastConsumptionTimestamp'] = $lastConsumptionTimestamp;
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
        return '[Twilio.Chat.V2.CreateMemberOptions ' . $options . ']';
    }
}

class ReadMemberOptions extends Options
{
    public function __construct(array $identity = Values::ARRAY_NONE)
    {
        $this->options['identity'] = $identity;
    }

    public function setIdentity(array $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.ReadMemberOptions ' . $options . ']';
    }
}

class DeleteMemberOptions extends Options
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
        return '[Twilio.Chat.V2.DeleteMemberOptions ' . $options . ']';
    }
}

class UpdateMemberOptions extends Options
{
    public function __construct(string $roleSid = Values::NONE, int $lastConsumedMessageIndex = Values::NONE, DateTime $lastConsumptionTimestamp = Values::NONE, DateTime $dateCreated = Values::NONE, DateTime $dateUpdated = Values::NONE, string $attributes = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
        $this->options['lastConsumedMessageIndex'] = $lastConsumedMessageIndex;
        $this->options['lastConsumptionTimestamp'] = $lastConsumptionTimestamp;
        $this->options['dateCreated'] = $dateCreated;
        $this->options['dateUpdated'] = $dateUpdated;
        $this->options['attributes'] = $attributes;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setLastConsumedMessageIndex(int $lastConsumedMessageIndex): self
    {
        $this->options['lastConsumedMessageIndex'] = $lastConsumedMessageIndex;
        return $this;
    }

    public function setLastConsumptionTimestamp(DateTime $lastConsumptionTimestamp): self
    {
        $this->options['lastConsumptionTimestamp'] = $lastConsumptionTimestamp;
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
        return '[Twilio.Chat.V2.UpdateMemberOptions ' . $options . ']';
    }
}