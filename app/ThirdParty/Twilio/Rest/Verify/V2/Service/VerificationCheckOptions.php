<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class VerificationCheckOptions
{
    public static function create(string $to = Values::NONE, string $verificationSid = Values::NONE, string $amount = Values::NONE, string $payee = Values::NONE): CreateVerificationCheckOptions
    {
        return new CreateVerificationCheckOptions($to, $verificationSid, $amount, $payee);
    }
}

class CreateVerificationCheckOptions extends Options
{
    public function __construct(string $to = Values::NONE, string $verificationSid = Values::NONE, string $amount = Values::NONE, string $payee = Values::NONE)
    {
        $this->options['to'] = $to;
        $this->options['verificationSid'] = $verificationSid;
        $this->options['amount'] = $amount;
        $this->options['payee'] = $payee;
    }

    public function setTo(string $to): self
    {
        $this->options['to'] = $to;
        return $this;
    }

    public function setVerificationSid(string $verificationSid): self
    {
        $this->options['verificationSid'] = $verificationSid;
        return $this;
    }

    public function setAmount(string $amount): self
    {
        $this->options['amount'] = $amount;
        return $this;
    }

    public function setPayee(string $payee): self
    {
        $this->options['payee'] = $payee;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateVerificationCheckOptions ' . $options . ']';
    }
}