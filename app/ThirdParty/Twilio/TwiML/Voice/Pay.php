<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Pay extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Pay', null, $attributes);
    }

    public function prompt($attributes = []): Prompt
    {
        return $this->nest(new Prompt($attributes));
    }

    public function parameter($attributes = []): Parameter
    {
        return $this->nest(new Parameter($attributes));
    }

    public function setInput($input): self
    {
        return $this->setAttribute('input', $input);
    }

    public function setAction($action): self
    {
        return $this->setAttribute('action', $action);
    }

    public function setBankAccountType($bankAccountType): self
    {
        return $this->setAttribute('bankAccountType', $bankAccountType);
    }

    public function setStatusCallback($statusCallback): self
    {
        return $this->setAttribute('statusCallback', $statusCallback);
    }

    public function setStatusCallbackMethod($statusCallbackMethod): self
    {
        return $this->setAttribute('statusCallbackMethod', $statusCallbackMethod);
    }

    public function setTimeout($timeout): self
    {
        return $this->setAttribute('timeout', $timeout);
    }

    public function setMaxAttempts($maxAttempts): self
    {
        return $this->setAttribute('maxAttempts', $maxAttempts);
    }

    public function setSecurityCode($securityCode): self
    {
        return $this->setAttribute('securityCode', $securityCode);
    }

    public function setPostalCode($postalCode): self
    {
        return $this->setAttribute('postalCode', $postalCode);
    }

    public function setMinPostalCodeLength($minPostalCodeLength): self
    {
        return $this->setAttribute('minPostalCodeLength', $minPostalCodeLength);
    }

    public function setPaymentConnector($paymentConnector): self
    {
        return $this->setAttribute('paymentConnector', $paymentConnector);
    }

    public function setPaymentMethod($paymentMethod): self
    {
        return $this->setAttribute('paymentMethod', $paymentMethod);
    }

    public function setTokenType($tokenType): self
    {
        return $this->setAttribute('tokenType', $tokenType);
    }

    public function setChargeAmount($chargeAmount): self
    {
        return $this->setAttribute('chargeAmount', $chargeAmount);
    }

    public function setCurrency($currency): self
    {
        return $this->setAttribute('currency', $currency);
    }

    public function setDescription($description): self
    {
        return $this->setAttribute('description', $description);
    }

    public function setValidCardTypes($validCardTypes): self
    {
        return $this->setAttribute('validCardTypes', $validCardTypes);
    }

    public function setLanguage($language): self
    {
        return $this->setAttribute('language', $language);
    }
}