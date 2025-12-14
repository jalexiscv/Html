<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ChannelOptions
{
    public static function create(string $target = Values::NONE, string $chatUniqueName = Values::NONE, string $preEngagementData = Values::NONE, string $taskSid = Values::NONE, string $taskAttributes = Values::NONE, bool $longLived = Values::NONE): CreateChannelOptions
    {
        return new CreateChannelOptions($target, $chatUniqueName, $preEngagementData, $taskSid, $taskAttributes, $longLived);
    }
}

class CreateChannelOptions extends Options
{
    public function __construct(string $target = Values::NONE, string $chatUniqueName = Values::NONE, string $preEngagementData = Values::NONE, string $taskSid = Values::NONE, string $taskAttributes = Values::NONE, bool $longLived = Values::NONE)
    {
        $this->options['target'] = $target;
        $this->options['chatUniqueName'] = $chatUniqueName;
        $this->options['preEngagementData'] = $preEngagementData;
        $this->options['taskSid'] = $taskSid;
        $this->options['taskAttributes'] = $taskAttributes;
        $this->options['longLived'] = $longLived;
    }

    public function setTarget(string $target): self
    {
        $this->options['target'] = $target;
        return $this;
    }

    public function setChatUniqueName(string $chatUniqueName): self
    {
        $this->options['chatUniqueName'] = $chatUniqueName;
        return $this;
    }

    public function setPreEngagementData(string $preEngagementData): self
    {
        $this->options['preEngagementData'] = $preEngagementData;
        return $this;
    }

    public function setTaskSid(string $taskSid): self
    {
        $this->options['taskSid'] = $taskSid;
        return $this;
    }

    public function setTaskAttributes(string $taskAttributes): self
    {
        $this->options['taskAttributes'] = $taskAttributes;
        return $this;
    }

    public function setLongLived(bool $longLived): self
    {
        $this->options['longLived'] = $longLived;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.FlexApi.V1.CreateChannelOptions ' . $options . ']';
    }
}