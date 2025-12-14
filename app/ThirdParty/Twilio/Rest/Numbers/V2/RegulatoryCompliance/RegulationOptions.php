<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RegulationOptions
{
    public static function read(string $endUserType = Values::NONE, string $isoCountry = Values::NONE, string $numberType = Values::NONE): ReadRegulationOptions
    {
        return new ReadRegulationOptions($endUserType, $isoCountry, $numberType);
    }
}

class ReadRegulationOptions extends Options
{
    public function __construct(string $endUserType = Values::NONE, string $isoCountry = Values::NONE, string $numberType = Values::NONE)
    {
        $this->options['endUserType'] = $endUserType;
        $this->options['isoCountry'] = $isoCountry;
        $this->options['numberType'] = $numberType;
    }

    public function setEndUserType(string $endUserType): self
    {
        $this->options['endUserType'] = $endUserType;
        return $this;
    }

    public function setIsoCountry(string $isoCountry): self
    {
        $this->options['isoCountry'] = $isoCountry;
        return $this;
    }

    public function setNumberType(string $numberType): self
    {
        $this->options['numberType'] = $numberType;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Numbers.V2.ReadRegulationOptions ' . $options . ']';
    }
}