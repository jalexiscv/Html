<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FleetOptions
{
    public static function create(string $uniqueName = Values::NONE, bool $dataEnabled = Values::NONE, int $dataLimit = Values::NONE, bool $commandsEnabled = Values::NONE, string $commandsUrl = Values::NONE, string $commandsMethod = Values::NONE): CreateFleetOptions
    {
        return new CreateFleetOptions($uniqueName, $dataEnabled, $dataLimit, $commandsEnabled, $commandsUrl, $commandsMethod);
    }

    public static function read(string $networkAccessProfile = Values::NONE): ReadFleetOptions
    {
        return new ReadFleetOptions($networkAccessProfile);
    }

    public static function update(string $uniqueName = Values::NONE, string $networkAccessProfile = Values::NONE, string $commandsUrl = Values::NONE, string $commandsMethod = Values::NONE): UpdateFleetOptions
    {
        return new UpdateFleetOptions($uniqueName, $networkAccessProfile, $commandsUrl, $commandsMethod);
    }
}

class CreateFleetOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, bool $dataEnabled = Values::NONE, int $dataLimit = Values::NONE, bool $commandsEnabled = Values::NONE, string $commandsUrl = Values::NONE, string $commandsMethod = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['dataEnabled'] = $dataEnabled;
        $this->options['dataLimit'] = $dataLimit;
        $this->options['commandsEnabled'] = $commandsEnabled;
        $this->options['commandsUrl'] = $commandsUrl;
        $this->options['commandsMethod'] = $commandsMethod;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setDataEnabled(bool $dataEnabled): self
    {
        $this->options['dataEnabled'] = $dataEnabled;
        return $this;
    }

    public function setDataLimit(int $dataLimit): self
    {
        $this->options['dataLimit'] = $dataLimit;
        return $this;
    }

    public function setCommandsEnabled(bool $commandsEnabled): self
    {
        $this->options['commandsEnabled'] = $commandsEnabled;
        return $this;
    }

    public function setCommandsUrl(string $commandsUrl): self
    {
        $this->options['commandsUrl'] = $commandsUrl;
        return $this;
    }

    public function setCommandsMethod(string $commandsMethod): self
    {
        $this->options['commandsMethod'] = $commandsMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.CreateFleetOptions ' . $options . ']';
    }
}

class ReadFleetOptions extends Options
{
    public function __construct(string $networkAccessProfile = Values::NONE)
    {
        $this->options['networkAccessProfile'] = $networkAccessProfile;
    }

    public function setNetworkAccessProfile(string $networkAccessProfile): self
    {
        $this->options['networkAccessProfile'] = $networkAccessProfile;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.ReadFleetOptions ' . $options . ']';
    }
}

class UpdateFleetOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, string $networkAccessProfile = Values::NONE, string $commandsUrl = Values::NONE, string $commandsMethod = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['networkAccessProfile'] = $networkAccessProfile;
        $this->options['commandsUrl'] = $commandsUrl;
        $this->options['commandsMethod'] = $commandsMethod;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setNetworkAccessProfile(string $networkAccessProfile): self
    {
        $this->options['networkAccessProfile'] = $networkAccessProfile;
        return $this;
    }

    public function setCommandsUrl(string $commandsUrl): self
    {
        $this->options['commandsUrl'] = $commandsUrl;
        return $this;
    }

    public function setCommandsMethod(string $commandsMethod): self
    {
        $this->options['commandsMethod'] = $commandsMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.UpdateFleetOptions ' . $options . ']';
    }
}