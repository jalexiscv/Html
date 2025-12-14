<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class PaymentOptions
{
    public static function create(string $bankAccountType = Values::NONE, string $chargeAmount = Values::NONE, string $currency = Values::NONE, string $description = Values::NONE, string $input = Values::NONE, int $minPostalCodeLength = Values::NONE, array $parameter = Values::ARRAY_NONE, string $paymentConnector = Values::NONE, string $paymentMethod = Values::NONE, bool $postalCode = Values::NONE, bool $securityCode = Values::NONE, int $timeout = Values::NONE, string $tokenType = Values::NONE, string $validCardTypes = Values::NONE): CreatePaymentOptions
    {
        return new CreatePaymentOptions($bankAccountType, $chargeAmount, $currency, $description, $input, $minPostalCodeLength, $parameter, $paymentConnector, $paymentMethod, $postalCode, $securityCode, $timeout, $tokenType, $validCardTypes);
    }

    public static function update(string $capture = Values::NONE, string $status = Values::NONE): UpdatePaymentOptions
    {
        return new UpdatePaymentOptions($capture, $status);
    }
}

class CreatePaymentOptions extends Options
{
    public function __construct(string $bankAccountType = Values::NONE, string $chargeAmount = Values::NONE, string $currency = Values::NONE, string $description = Values::NONE, string $input = Values::NONE, int $minPostalCodeLength = Values::NONE, array $parameter = Values::ARRAY_NONE, string $paymentConnector = Values::NONE, string $paymentMethod = Values::NONE, bool $postalCode = Values::NONE, bool $securityCode = Values::NONE, int $timeout = Values::NONE, string $tokenType = Values::NONE, string $validCardTypes = Values::NONE)
    {
        $this->options['bankAccountType'] = $bankAccountType;
        $this->options['chargeAmount'] = $chargeAmount;
        $this->options['currency'] = $currency;
        $this->options['description'] = $description;
        $this->options['input'] = $input;
        $this->options['minPostalCodeLength'] = $minPostalCodeLength;
        $this->options['parameter'] = $parameter;
        $this->options['paymentConnector'] = $paymentConnector;
        $this->options['paymentMethod'] = $paymentMethod;
        $this->options['postalCode'] = $postalCode;
        $this->options['securityCode'] = $securityCode;
        $this->options['timeout'] = $timeout;
        $this->options['tokenType'] = $tokenType;
        $this->options['validCardTypes'] = $validCardTypes;
    }

    public function setBankAccountType(string $bankAccountType): self
    {
        $this->options['bankAccountType'] = $bankAccountType;
        return $this;
    }

    public function setChargeAmount(string $chargeAmount): self
    {
        $this->options['chargeAmount'] = $chargeAmount;
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->options['currency'] = $currency;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->options['description'] = $description;
        return $this;
    }

    public function setInput(string $input): self
    {
        $this->options['input'] = $input;
        return $this;
    }

    public function setMinPostalCodeLength(int $minPostalCodeLength): self
    {
        $this->options['minPostalCodeLength'] = $minPostalCodeLength;
        return $this;
    }

    public function setParameter(array $parameter): self
    {
        $this->options['parameter'] = $parameter;
        return $this;
    }

    public function setPaymentConnector(string $paymentConnector): self
    {
        $this->options['paymentConnector'] = $paymentConnector;
        return $this;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->options['paymentMethod'] = $paymentMethod;
        return $this;
    }

    public function setPostalCode(bool $postalCode): self
    {
        $this->options['postalCode'] = $postalCode;
        return $this;
    }

    public function setSecurityCode(bool $securityCode): self
    {
        $this->options['securityCode'] = $securityCode;
        return $this;
    }

    public function setTimeout(int $timeout): self
    {
        $this->options['timeout'] = $timeout;
        return $this;
    }

    public function setTokenType(string $tokenType): self
    {
        $this->options['tokenType'] = $tokenType;
        return $this;
    }

    public function setValidCardTypes(string $validCardTypes): self
    {
        $this->options['validCardTypes'] = $validCardTypes;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreatePaymentOptions ' . $options . ']';
    }
}

class UpdatePaymentOptions extends Options
{
    public function __construct(string $capture = Values::NONE, string $status = Values::NONE)
    {
        $this->options['capture'] = $capture;
        $this->options['status'] = $status;
    }

    public function setCapture(string $capture): self
    {
        $this->options['capture'] = $capture;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdatePaymentOptions ' . $options . ']';
    }
}