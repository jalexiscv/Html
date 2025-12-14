<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;

class ConfigurationContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Configuration';
    }

    public function fetch(array $options = []): ConfigurationInstance
    {
        $options = new Values($options);
        $params = Values::of(['UiVersion' => $options['uiVersion'],]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new ConfigurationInstance($this->version, $payload);
    }

    public function create(): ConfigurationInstance
    {
        $payload = $this->version->create('POST', $this->uri);
        return new ConfigurationInstance($this->version, $payload);
    }

    public function update(): ConfigurationInstance
    {
        $payload = $this->version->update('POST', $this->uri);
        return new ConfigurationInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.FlexApi.V1.ConfigurationContext ' . implode(' ', $context) . ']';
    }
}