<?php

namespace Twilio\Rest\Chat\V2\Service\User;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class UserChannelOptions
{
    public static function update(string $notificationLevel = Values::NONE, int $lastConsumedMessageIndex = Values::NONE, DateTime $lastConsumptionTimestamp = Values::NONE): UpdateUserChannelOptions
    {
        return new UpdateUserChannelOptions($notificationLevel, $lastConsumedMessageIndex, $lastConsumptionTimestamp);
    }
}

class UpdateUserChannelOptions extends Options
{
    public function __construct(string $notificationLevel = Values::NONE, int $lastConsumedMessageIndex = Values::NONE, DateTime $lastConsumptionTimestamp = Values::NONE)
    {
        $this->options['notificationLevel'] = $notificationLevel;
        $this->options['lastConsumedMessageIndex'] = $lastConsumedMessageIndex;
        $this->options['lastConsumptionTimestamp'] = $lastConsumptionTimestamp;
    }

    public function setNotificationLevel(string $notificationLevel): self
    {
        $this->options['notificationLevel'] = $notificationLevel;
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

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.UpdateUserChannelOptions ' . $options . ']';
    }
}