<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class NetworkOptions
{
    public static function read(string $isoCountry = Values::NONE, string $mcc = Values::NONE, string $mnc = Values::NONE): ReadNetworkOptions
    {
        return new ReadNetworkOptions($isoCountry, $mcc, $mnc);
    }
}

class ReadNetworkOptions extends Options
{
    public function __construct(string $isoCountry = Values::NONE, string $mcc = Values::NONE, string $mnc = Values::NONE)
    {
        $this->options['isoCountry'] = $isoCountry;
        $this->options['mcc'] = $mcc;
        $this->options['mnc'] = $mnc;
    }

    public function setIsoCountry(string $isoCountry): self
    {
        $this->options['isoCountry'] = $isoCountry;
        return $this;
    }

    public function setMcc(string $mcc): self
    {
        $this->options['mcc'] = $mcc;
        return $this;
    }

    public function setMnc(string $mnc): self
    {
        $this->options['mnc'] = $mnc;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.ReadNetworkOptions ' . $options . ']';
    }
}