<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class OriginationUrlOptions
{
    public static function update(int $weight = Values::NONE, int $priority = Values::NONE, bool $enabled = Values::NONE, string $friendlyName = Values::NONE, string $sipUrl = Values::NONE): UpdateOriginationUrlOptions
    {
        return new UpdateOriginationUrlOptions($weight, $priority, $enabled, $friendlyName, $sipUrl);
    }
}

class UpdateOriginationUrlOptions extends Options
{
    public function __construct(int $weight = Values::NONE, int $priority = Values::NONE, bool $enabled = Values::NONE, string $friendlyName = Values::NONE, string $sipUrl = Values::NONE)
    {
        $this->options['weight'] = $weight;
        $this->options['priority'] = $priority;
        $this->options['enabled'] = $enabled;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['sipUrl'] = $sipUrl;
    }

    public function setWeight(int $weight): self
    {
        $this->options['weight'] = $weight;
        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setSipUrl(string $sipUrl): self
    {
        $this->options['sipUrl'] = $sipUrl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Trunking.V1.UpdateOriginationUrlOptions ' . $options . ']';
    }
}