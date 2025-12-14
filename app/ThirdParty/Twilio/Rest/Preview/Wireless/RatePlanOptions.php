<?php

namespace Twilio\Rest\Preview\Wireless;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RatePlanOptions
{
    public static function create(string $uniqueName = Values::NONE, string $friendlyName = Values::NONE, bool $dataEnabled = Values::NONE, int $dataLimit = Values::NONE, string $dataMetering = Values::NONE, bool $messagingEnabled = Values::NONE, bool $voiceEnabled = Values::NONE, bool $commandsEnabled = Values::NONE, bool $nationalRoamingEnabled = Values::NONE, array $internationalRoaming = Values::ARRAY_NONE): CreateRatePlanOptions
    {
        return new CreateRatePlanOptions($uniqueName, $friendlyName, $dataEnabled, $dataLimit, $dataMetering, $messagingEnabled, $voiceEnabled, $commandsEnabled, $nationalRoamingEnabled, $internationalRoaming);
    }

    public static function update(string $uniqueName = Values::NONE, string $friendlyName = Values::NONE): UpdateRatePlanOptions
    {
        return new UpdateRatePlanOptions($uniqueName, $friendlyName);
    }
}

class CreateRatePlanOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, string $friendlyName = Values::NONE, bool $dataEnabled = Values::NONE, int $dataLimit = Values::NONE, string $dataMetering = Values::NONE, bool $messagingEnabled = Values::NONE, bool $voiceEnabled = Values::NONE, bool $commandsEnabled = Values::NONE, bool $nationalRoamingEnabled = Values::NONE, array $internationalRoaming = Values::ARRAY_NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['dataEnabled'] = $dataEnabled;
        $this->options['dataLimit'] = $dataLimit;
        $this->options['dataMetering'] = $dataMetering;
        $this->options['messagingEnabled'] = $messagingEnabled;
        $this->options['voiceEnabled'] = $voiceEnabled;
        $this->options['commandsEnabled'] = $commandsEnabled;
        $this->options['nationalRoamingEnabled'] = $nationalRoamingEnabled;
        $this->options['internationalRoaming'] = $internationalRoaming;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
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

    public function setDataMetering(string $dataMetering): self
    {
        $this->options['dataMetering'] = $dataMetering;
        return $this;
    }

    public function setMessagingEnabled(bool $messagingEnabled): self
    {
        $this->options['messagingEnabled'] = $messagingEnabled;
        return $this;
    }

    public function setVoiceEnabled(bool $voiceEnabled): self
    {
        $this->options['voiceEnabled'] = $voiceEnabled;
        return $this;
    }

    public function setCommandsEnabled(bool $commandsEnabled): self
    {
        $this->options['commandsEnabled'] = $commandsEnabled;
        return $this;
    }

    public function setNationalRoamingEnabled(bool $nationalRoamingEnabled): self
    {
        $this->options['nationalRoamingEnabled'] = $nationalRoamingEnabled;
        return $this;
    }

    public function setInternationalRoaming(array $internationalRoaming): self
    {
        $this->options['internationalRoaming'] = $internationalRoaming;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Wireless.CreateRatePlanOptions ' . $options . ']';
    }
}

class UpdateRatePlanOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, string $friendlyName = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Wireless.UpdateRatePlanOptions ' . $options . ']';
    }
}