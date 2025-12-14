<?php

namespace Twilio\Rest\Wireless\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SimOptions
{
    public static function read(string $status = Values::NONE, string $iccid = Values::NONE, string $ratePlan = Values::NONE, string $eId = Values::NONE, string $simRegistrationCode = Values::NONE): ReadSimOptions
    {
        return new ReadSimOptions($status, $iccid, $ratePlan, $eId, $simRegistrationCode);
    }

    public static function update(string $uniqueName = Values::NONE, string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $friendlyName = Values::NONE, string $ratePlan = Values::NONE, string $status = Values::NONE, string $commandsCallbackMethod = Values::NONE, string $commandsCallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceUrl = Values::NONE, string $resetStatus = Values::NONE, string $accountSid = Values::NONE): UpdateSimOptions
    {
        return new UpdateSimOptions($uniqueName, $callbackMethod, $callbackUrl, $friendlyName, $ratePlan, $status, $commandsCallbackMethod, $commandsCallbackUrl, $smsFallbackMethod, $smsFallbackUrl, $smsMethod, $smsUrl, $voiceFallbackMethod, $voiceFallbackUrl, $voiceMethod, $voiceUrl, $resetStatus, $accountSid);
    }
}

class ReadSimOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $iccid = Values::NONE, string $ratePlan = Values::NONE, string $eId = Values::NONE, string $simRegistrationCode = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['iccid'] = $iccid;
        $this->options['ratePlan'] = $ratePlan;
        $this->options['eId'] = $eId;
        $this->options['simRegistrationCode'] = $simRegistrationCode;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setIccid(string $iccid): self
    {
        $this->options['iccid'] = $iccid;
        return $this;
    }

    public function setRatePlan(string $ratePlan): self
    {
        $this->options['ratePlan'] = $ratePlan;
        return $this;
    }

    public function setEId(string $eId): self
    {
        $this->options['eId'] = $eId;
        return $this;
    }

    public function setSimRegistrationCode(string $simRegistrationCode): self
    {
        $this->options['simRegistrationCode'] = $simRegistrationCode;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Wireless.V1.ReadSimOptions ' . $options . ']';
    }
}

class UpdateSimOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $friendlyName = Values::NONE, string $ratePlan = Values::NONE, string $status = Values::NONE, string $commandsCallbackMethod = Values::NONE, string $commandsCallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsUrl = Values::NONE, string $voiceFallbackMethod = Values::NONE, string $voiceFallbackUrl = Values::NONE, string $voiceMethod = Values::NONE, string $voiceUrl = Values::NONE, string $resetStatus = Values::NONE, string $accountSid = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['callbackMethod'] = $callbackMethod;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['ratePlan'] = $ratePlan;
        $this->options['status'] = $status;
        $this->options['commandsCallbackMethod'] = $commandsCallbackMethod;
        $this->options['commandsCallbackUrl'] = $commandsCallbackUrl;
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        $this->options['smsMethod'] = $smsMethod;
        $this->options['smsUrl'] = $smsUrl;
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        $this->options['voiceMethod'] = $voiceMethod;
        $this->options['voiceUrl'] = $voiceUrl;
        $this->options['resetStatus'] = $resetStatus;
        $this->options['accountSid'] = $accountSid;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setCallbackMethod(string $callbackMethod): self
    {
        $this->options['callbackMethod'] = $callbackMethod;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setRatePlan(string $ratePlan): self
    {
        $this->options['ratePlan'] = $ratePlan;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setCommandsCallbackMethod(string $commandsCallbackMethod): self
    {
        $this->options['commandsCallbackMethod'] = $commandsCallbackMethod;
        return $this;
    }

    public function setCommandsCallbackUrl(string $commandsCallbackUrl): self
    {
        $this->options['commandsCallbackUrl'] = $commandsCallbackUrl;
        return $this;
    }

    public function setSmsFallbackMethod(string $smsFallbackMethod): self
    {
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        return $this;
    }

    public function setSmsFallbackUrl(string $smsFallbackUrl): self
    {
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        return $this;
    }

    public function setSmsMethod(string $smsMethod): self
    {
        $this->options['smsMethod'] = $smsMethod;
        return $this;
    }

    public function setSmsUrl(string $smsUrl): self
    {
        $this->options['smsUrl'] = $smsUrl;
        return $this;
    }

    public function setVoiceFallbackMethod(string $voiceFallbackMethod): self
    {
        $this->options['voiceFallbackMethod'] = $voiceFallbackMethod;
        return $this;
    }

    public function setVoiceFallbackUrl(string $voiceFallbackUrl): self
    {
        $this->options['voiceFallbackUrl'] = $voiceFallbackUrl;
        return $this;
    }

    public function setVoiceMethod(string $voiceMethod): self
    {
        $this->options['voiceMethod'] = $voiceMethod;
        return $this;
    }

    public function setVoiceUrl(string $voiceUrl): self
    {
        $this->options['voiceUrl'] = $voiceUrl;
        return $this;
    }

    public function setResetStatus(string $resetStatus): self
    {
        $this->options['resetStatus'] = $resetStatus;
        return $this;
    }

    public function setAccountSid(string $accountSid): self
    {
        $this->options['accountSid'] = $accountSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Wireless.V1.UpdateSimOptions ' . $options . ']';
    }
}