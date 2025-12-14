<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SimOptions
{
    public static function update(string $uniqueName = Values::NONE, string $status = Values::NONE, string $fleet = Values::NONE, string $callbackUrl = Values::NONE, string $callbackMethod = Values::NONE, string $accountSid = Values::NONE): UpdateSimOptions
    {
        return new UpdateSimOptions($uniqueName, $status, $fleet, $callbackUrl, $callbackMethod, $accountSid);
    }

    public static function read(string $status = Values::NONE, string $fleet = Values::NONE, string $iccid = Values::NONE): ReadSimOptions
    {
        return new ReadSimOptions($status, $fleet, $iccid);
    }
}

class UpdateSimOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, string $status = Values::NONE, string $fleet = Values::NONE, string $callbackUrl = Values::NONE, string $callbackMethod = Values::NONE, string $accountSid = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['status'] = $status;
        $this->options['fleet'] = $fleet;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['callbackMethod'] = $callbackMethod;
        $this->options['accountSid'] = $accountSid;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setFleet(string $fleet): self
    {
        $this->options['fleet'] = $fleet;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setCallbackMethod(string $callbackMethod): self
    {
        $this->options['callbackMethod'] = $callbackMethod;
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
        return '[Twilio.Supersim.V1.UpdateSimOptions ' . $options . ']';
    }
}

class ReadSimOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $fleet = Values::NONE, string $iccid = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['fleet'] = $fleet;
        $this->options['iccid'] = $iccid;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setFleet(string $fleet): self
    {
        $this->options['fleet'] = $fleet;
        return $this;
    }

    public function setIccid(string $iccid): self
    {
        $this->options['iccid'] = $iccid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.ReadSimOptions ' . $options . ']';
    }
}