<?php

namespace Twilio\Rest\Preview\Marketplace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class InstalledAddOnOptions
{
    public static function create(array $configuration = Values::ARRAY_NONE, string $uniqueName = Values::NONE): CreateInstalledAddOnOptions
    {
        return new CreateInstalledAddOnOptions($configuration, $uniqueName);
    }

    public static function update(array $configuration = Values::ARRAY_NONE, string $uniqueName = Values::NONE): UpdateInstalledAddOnOptions
    {
        return new UpdateInstalledAddOnOptions($configuration, $uniqueName);
    }
}

class CreateInstalledAddOnOptions extends Options
{
    public function __construct(array $configuration = Values::ARRAY_NONE, string $uniqueName = Values::NONE)
    {
        $this->options['configuration'] = $configuration;
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setConfiguration(array $configuration): self
    {
        $this->options['configuration'] = $configuration;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Marketplace.CreateInstalledAddOnOptions ' . $options . ']';
    }
}

class UpdateInstalledAddOnOptions extends Options
{
    public function __construct(array $configuration = Values::ARRAY_NONE, string $uniqueName = Values::NONE)
    {
        $this->options['configuration'] = $configuration;
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setConfiguration(array $configuration): self
    {
        $this->options['configuration'] = $configuration;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Marketplace.UpdateInstalledAddOnOptions ' . $options . ']';
    }
}