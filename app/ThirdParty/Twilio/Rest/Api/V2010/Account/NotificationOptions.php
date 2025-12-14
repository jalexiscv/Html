<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class NotificationOptions
{
    public static function read(int $log = Values::NONE, string $messageDateBefore = Values::NONE, string $messageDate = Values::NONE, string $messageDateAfter = Values::NONE): ReadNotificationOptions
    {
        return new ReadNotificationOptions($log, $messageDateBefore, $messageDate, $messageDateAfter);
    }
}

class ReadNotificationOptions extends Options
{
    public function __construct(int $log = Values::NONE, string $messageDateBefore = Values::NONE, string $messageDate = Values::NONE, string $messageDateAfter = Values::NONE)
    {
        $this->options['log'] = $log;
        $this->options['messageDateBefore'] = $messageDateBefore;
        $this->options['messageDate'] = $messageDate;
        $this->options['messageDateAfter'] = $messageDateAfter;
    }

    public function setLog(int $log): self
    {
        $this->options['log'] = $log;
        return $this;
    }

    public function setMessageDateBefore(string $messageDateBefore): self
    {
        $this->options['messageDateBefore'] = $messageDateBefore;
        return $this;
    }

    public function setMessageDate(string $messageDate): self
    {
        $this->options['messageDate'] = $messageDate;
        return $this;
    }

    public function setMessageDateAfter(string $messageDateAfter): self
    {
        $this->options['messageDateAfter'] = $messageDateAfter;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadNotificationOptions ' . $options . ']';
    }
}