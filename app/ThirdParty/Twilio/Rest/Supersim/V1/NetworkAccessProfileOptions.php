<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class NetworkAccessProfileOptions
{
    public static function create(string $uniqueName = Values::NONE, array $networks = Values::ARRAY_NONE): CreateNetworkAccessProfileOptions
    {
        return new CreateNetworkAccessProfileOptions($uniqueName, $networks);
    }

    public static function update(string $uniqueName = Values::NONE): UpdateNetworkAccessProfileOptions
    {
        return new UpdateNetworkAccessProfileOptions($uniqueName);
    }
}

class CreateNetworkAccessProfileOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, array $networks = Values::ARRAY_NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['networks'] = $networks;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setNetworks(array $networks): self
    {
        $this->options['networks'] = $networks;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.CreateNetworkAccessProfileOptions ' . $options . ']';
    }
}

class UpdateNetworkAccessProfileOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.UpdateNetworkAccessProfileOptions ' . $options . ']';
    }
}