<?php

namespace Twilio\Rest\Serverless\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function create(bool $includeCredentials = Values::NONE, bool $uiEditable = Values::NONE): CreateServiceOptions
    {
        return new CreateServiceOptions($includeCredentials, $uiEditable);
    }

    public static function update(bool $includeCredentials = Values::NONE, string $friendlyName = Values::NONE, bool $uiEditable = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($includeCredentials, $friendlyName, $uiEditable);
    }
}

class CreateServiceOptions extends Options
{
    public function __construct(bool $includeCredentials = Values::NONE, bool $uiEditable = Values::NONE)
    {
        $this->options['includeCredentials'] = $includeCredentials;
        $this->options['uiEditable'] = $uiEditable;
    }

    public function setIncludeCredentials(bool $includeCredentials): self
    {
        $this->options['includeCredentials'] = $includeCredentials;
        return $this;
    }

    public function setUiEditable(bool $uiEditable): self
    {
        $this->options['uiEditable'] = $uiEditable;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Serverless.V1.CreateServiceOptions ' . $options . ']';
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(bool $includeCredentials = Values::NONE, string $friendlyName = Values::NONE, bool $uiEditable = Values::NONE)
    {
        $this->options['includeCredentials'] = $includeCredentials;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uiEditable'] = $uiEditable;
    }

    public function setIncludeCredentials(bool $includeCredentials): self
    {
        $this->options['includeCredentials'] = $includeCredentials;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUiEditable(bool $uiEditable): self
    {
        $this->options['uiEditable'] = $uiEditable;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Serverless.V1.UpdateServiceOptions ' . $options . ']';
    }
}