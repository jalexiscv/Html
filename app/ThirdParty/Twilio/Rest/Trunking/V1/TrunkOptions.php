<?php

namespace Twilio\Rest\Trunking\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TrunkOptions
{
    public static function create(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE): CreateTrunkOptions
    {
        return new CreateTrunkOptions($friendlyName, $domainName, $disasterRecoveryUrl, $disasterRecoveryMethod, $transferMode, $secure, $cnamLookupEnabled);
    }

    public static function update(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE): UpdateTrunkOptions
    {
        return new UpdateTrunkOptions($friendlyName, $domainName, $disasterRecoveryUrl, $disasterRecoveryMethod, $transferMode, $secure, $cnamLookupEnabled);
    }
}

class CreateTrunkOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['domainName'] = $domainName;
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;
        $this->options['transferMode'] = $transferMode;
        $this->options['secure'] = $secure;
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setDomainName(string $domainName): self
    {
        $this->options['domainName'] = $domainName;
        return $this;
    }

    public function setDisasterRecoveryUrl(string $disasterRecoveryUrl): self
    {
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;
        return $this;
    }

    public function setDisasterRecoveryMethod(string $disasterRecoveryMethod): self
    {
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;
        return $this;
    }

    public function setTransferMode(string $transferMode): self
    {
        $this->options['transferMode'] = $transferMode;
        return $this;
    }

    public function setSecure(bool $secure): self
    {
        $this->options['secure'] = $secure;
        return $this;
    }

    public function setCnamLookupEnabled(bool $cnamLookupEnabled): self
    {
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Trunking.V1.CreateTrunkOptions ' . $options . ']';
    }
}

class UpdateTrunkOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['domainName'] = $domainName;
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;
        $this->options['transferMode'] = $transferMode;
        $this->options['secure'] = $secure;
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setDomainName(string $domainName): self
    {
        $this->options['domainName'] = $domainName;
        return $this;
    }

    public function setDisasterRecoveryUrl(string $disasterRecoveryUrl): self
    {
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;
        return $this;
    }

    public function setDisasterRecoveryMethod(string $disasterRecoveryMethod): self
    {
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;
        return $this;
    }

    public function setTransferMode(string $transferMode): self
    {
        $this->options['transferMode'] = $transferMode;
        return $this;
    }

    public function setSecure(bool $secure): self
    {
        $this->options['secure'] = $secure;
        return $this;
    }

    public function setCnamLookupEnabled(bool $cnamLookupEnabled): self
    {
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Trunking.V1.UpdateTrunkOptions ' . $options . ']';
    }
}