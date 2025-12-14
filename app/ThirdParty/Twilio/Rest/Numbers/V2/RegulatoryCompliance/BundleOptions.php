<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class BundleOptions
{
    public static function create(string $statusCallback = Values::NONE, string $regulationSid = Values::NONE, string $isoCountry = Values::NONE, string $endUserType = Values::NONE, string $numberType = Values::NONE): CreateBundleOptions
    {
        return new CreateBundleOptions($statusCallback, $regulationSid, $isoCountry, $endUserType, $numberType);
    }

    public static function read(string $status = Values::NONE, string $friendlyName = Values::NONE, string $regulationSid = Values::NONE, string $isoCountry = Values::NONE, string $numberType = Values::NONE): ReadBundleOptions
    {
        return new ReadBundleOptions($status, $friendlyName, $regulationSid, $isoCountry, $numberType);
    }

    public static function update(string $status = Values::NONE, string $statusCallback = Values::NONE, string $friendlyName = Values::NONE, string $email = Values::NONE): UpdateBundleOptions
    {
        return new UpdateBundleOptions($status, $statusCallback, $friendlyName, $email);
    }
}

class CreateBundleOptions extends Options
{
    public function __construct(string $statusCallback = Values::NONE, string $regulationSid = Values::NONE, string $isoCountry = Values::NONE, string $endUserType = Values::NONE, string $numberType = Values::NONE)
    {
        $this->options['statusCallback'] = $statusCallback;
        $this->options['regulationSid'] = $regulationSid;
        $this->options['isoCountry'] = $isoCountry;
        $this->options['endUserType'] = $endUserType;
        $this->options['numberType'] = $numberType;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setRegulationSid(string $regulationSid): self
    {
        $this->options['regulationSid'] = $regulationSid;
        return $this;
    }

    public function setIsoCountry(string $isoCountry): self
    {
        $this->options['isoCountry'] = $isoCountry;
        return $this;
    }

    public function setEndUserType(string $endUserType): self
    {
        $this->options['endUserType'] = $endUserType;
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
        return '[Twilio.Numbers.V2.CreateBundleOptions ' . $options . ']';
    }
}

class ReadBundleOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $friendlyName = Values::NONE, string $regulationSid = Values::NONE, string $isoCountry = Values::NONE, string $numberType = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['regulationSid'] = $regulationSid;
        $this->options['isoCountry'] = $isoCountry;
        $this->options['numberType'] = $numberType;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setRegulationSid(string $regulationSid): self
    {
        $this->options['regulationSid'] = $regulationSid;
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
        return '[Twilio.Numbers.V2.ReadBundleOptions ' . $options . ']';
    }
}

class UpdateBundleOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $statusCallback = Values::NONE, string $friendlyName = Values::NONE, string $email = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['email'] = $email;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->options['email'] = $email;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Numbers.V2.UpdateBundleOptions ' . $options . ']';
    }
}