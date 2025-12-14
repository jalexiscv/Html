<?php

namespace Twilio\Rest\Verify\V2;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function create(int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE): CreateServiceOptions
    {
        return new CreateServiceOptions($codeLength, $lookupEnabled, $skipSmsToLandlines, $dtmfInputRequired, $ttsName, $psd2Enabled, $doNotShareWarningEnabled, $customCodeEnabled, $pushIncludeDate, $pushApnCredentialSid, $pushFcmCredentialSid);
    }

    public static function update(string $friendlyName = Values::NONE, int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($friendlyName, $codeLength, $lookupEnabled, $skipSmsToLandlines, $dtmfInputRequired, $ttsName, $psd2Enabled, $doNotShareWarningEnabled, $customCodeEnabled, $pushIncludeDate, $pushApnCredentialSid, $pushFcmCredentialSid);
    }
}

class CreateServiceOptions extends Options
{
    public function __construct(int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE)
    {
        $this->options['codeLength'] = $codeLength;
        $this->options['lookupEnabled'] = $lookupEnabled;
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;
        $this->options['ttsName'] = $ttsName;
        $this->options['psd2Enabled'] = $psd2Enabled;
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;
        $this->options['customCodeEnabled'] = $customCodeEnabled;
        $this->options['pushIncludeDate'] = $pushIncludeDate;
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;
    }

    public function setCodeLength(int $codeLength): self
    {
        $this->options['codeLength'] = $codeLength;
        return $this;
    }

    public function setLookupEnabled(bool $lookupEnabled): self
    {
        $this->options['lookupEnabled'] = $lookupEnabled;
        return $this;
    }

    public function setSkipSmsToLandlines(bool $skipSmsToLandlines): self
    {
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;
        return $this;
    }

    public function setDtmfInputRequired(bool $dtmfInputRequired): self
    {
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;
        return $this;
    }

    public function setTtsName(string $ttsName): self
    {
        $this->options['ttsName'] = $ttsName;
        return $this;
    }

    public function setPsd2Enabled(bool $psd2Enabled): self
    {
        $this->options['psd2Enabled'] = $psd2Enabled;
        return $this;
    }

    public function setDoNotShareWarningEnabled(bool $doNotShareWarningEnabled): self
    {
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;
        return $this;
    }

    public function setCustomCodeEnabled(bool $customCodeEnabled): self
    {
        $this->options['customCodeEnabled'] = $customCodeEnabled;
        return $this;
    }

    public function setPushIncludeDate(bool $pushIncludeDate): self
    {
        $this->options['pushIncludeDate'] = $pushIncludeDate;
        return $this;
    }

    public function setPushApnCredentialSid(string $pushApnCredentialSid): self
    {
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;
        return $this;
    }

    public function setPushFcmCredentialSid(string $pushFcmCredentialSid): self
    {
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateServiceOptions ' . $options . ']';
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['codeLength'] = $codeLength;
        $this->options['lookupEnabled'] = $lookupEnabled;
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;
        $this->options['ttsName'] = $ttsName;
        $this->options['psd2Enabled'] = $psd2Enabled;
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;
        $this->options['customCodeEnabled'] = $customCodeEnabled;
        $this->options['pushIncludeDate'] = $pushIncludeDate;
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setCodeLength(int $codeLength): self
    {
        $this->options['codeLength'] = $codeLength;
        return $this;
    }

    public function setLookupEnabled(bool $lookupEnabled): self
    {
        $this->options['lookupEnabled'] = $lookupEnabled;
        return $this;
    }

    public function setSkipSmsToLandlines(bool $skipSmsToLandlines): self
    {
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;
        return $this;
    }

    public function setDtmfInputRequired(bool $dtmfInputRequired): self
    {
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;
        return $this;
    }

    public function setTtsName(string $ttsName): self
    {
        $this->options['ttsName'] = $ttsName;
        return $this;
    }

    public function setPsd2Enabled(bool $psd2Enabled): self
    {
        $this->options['psd2Enabled'] = $psd2Enabled;
        return $this;
    }

    public function setDoNotShareWarningEnabled(bool $doNotShareWarningEnabled): self
    {
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;
        return $this;
    }

    public function setCustomCodeEnabled(bool $customCodeEnabled): self
    {
        $this->options['customCodeEnabled'] = $customCodeEnabled;
        return $this;
    }

    public function setPushIncludeDate(bool $pushIncludeDate): self
    {
        $this->options['pushIncludeDate'] = $pushIncludeDate;
        return $this;
    }

    public function setPushApnCredentialSid(string $pushApnCredentialSid): self
    {
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;
        return $this;
    }

    public function setPushFcmCredentialSid(string $pushFcmCredentialSid): self
    {
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.UpdateServiceOptions ' . $options . ']';
    }
}