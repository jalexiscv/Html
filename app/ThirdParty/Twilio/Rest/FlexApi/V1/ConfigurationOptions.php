<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConfigurationOptions
{
    public static function fetch(string $uiVersion = Values::NONE): FetchConfigurationOptions
    {
        return new FetchConfigurationOptions($uiVersion);
    }
}

class FetchConfigurationOptions extends Options
{
    public function __construct(string $uiVersion = Values::NONE)
    {
        $this->options['uiVersion'] = $uiVersion;
    }

    public function setUiVersion(string $uiVersion): self
    {
        $this->options['uiVersion'] = $uiVersion;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.FlexApi.V1.FetchConfigurationOptions ' . $options . ']';
    }
}