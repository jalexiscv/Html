<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WebChannelOptions
{
    public static function create(string $chatUniqueName = Values::NONE, string $preEngagementData = Values::NONE): CreateWebChannelOptions
    {
        return new CreateWebChannelOptions($chatUniqueName, $preEngagementData);
    }

    public static function update(string $chatStatus = Values::NONE, string $postEngagementData = Values::NONE): UpdateWebChannelOptions
    {
        return new UpdateWebChannelOptions($chatStatus, $postEngagementData);
    }
}

class CreateWebChannelOptions extends Options
{
    public function __construct(string $chatUniqueName = Values::NONE, string $preEngagementData = Values::NONE)
    {
        $this->options['chatUniqueName'] = $chatUniqueName;
        $this->options['preEngagementData'] = $preEngagementData;
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

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.FlexApi.V1.CreateWebChannelOptions ' . $options . ']';
    }
}

class UpdateWebChannelOptions extends Options
{
    public function __construct(string $chatStatus = Values::NONE, string $postEngagementData = Values::NONE)
    {
        $this->options['chatStatus'] = $chatStatus;
        $this->options['postEngagementData'] = $postEngagementData;
    }

    public function setChatStatus(string $chatStatus): self
    {
        $this->options['chatStatus'] = $chatStatus;
        return $this;
    }

    public function setPostEngagementData(string $postEngagementData): self
    {
        $this->options['postEngagementData'] = $postEngagementData;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.FlexApi.V1.UpdateWebChannelOptions ' . $options . ']';
    }
}