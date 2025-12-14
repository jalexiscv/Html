<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class VerificationOptions
{
    public static function create(string $customFriendlyName = Values::NONE, string $customMessage = Values::NONE, string $sendDigits = Values::NONE, string $locale = Values::NONE, string $customCode = Values::NONE, string $amount = Values::NONE, string $payee = Values::NONE, array $rateLimits = Values::ARRAY_NONE, array $channelConfiguration = Values::ARRAY_NONE, string $appHash = Values::NONE): CreateVerificationOptions
    {
        return new CreateVerificationOptions($customFriendlyName, $customMessage, $sendDigits, $locale, $customCode, $amount, $payee, $rateLimits, $channelConfiguration, $appHash);
    }
}

class CreateVerificationOptions extends Options
{
    public function __construct(string $customFriendlyName = Values::NONE, string $customMessage = Values::NONE, string $sendDigits = Values::NONE, string $locale = Values::NONE, string $customCode = Values::NONE, string $amount = Values::NONE, string $payee = Values::NONE, array $rateLimits = Values::ARRAY_NONE, array $channelConfiguration = Values::ARRAY_NONE, string $appHash = Values::NONE)
    {
        $this->options['customFriendlyName'] = $customFriendlyName;
        $this->options['customMessage'] = $customMessage;
        $this->options['sendDigits'] = $sendDigits;
        $this->options['locale'] = $locale;
        $this->options['customCode'] = $customCode;
        $this->options['amount'] = $amount;
        $this->options['payee'] = $payee;
        $this->options['rateLimits'] = $rateLimits;
        $this->options['channelConfiguration'] = $channelConfiguration;
        $this->options['appHash'] = $appHash;
    }

    public function setCustomFriendlyName(string $customFriendlyName): self
    {
        $this->options['customFriendlyName'] = $customFriendlyName;
        return $this;
    }

    public function setCustomMessage(string $customMessage): self
    {
        $this->options['customMessage'] = $customMessage;
        return $this;
    }

    public function setSendDigits(string $sendDigits): self
    {
        $this->options['sendDigits'] = $sendDigits;
        return $this;
    }

    public function setLocale(string $locale): self
    {
        $this->options['locale'] = $locale;
        return $this;
    }

    public function setCustomCode(string $customCode): self
    {
        $this->options['customCode'] = $customCode;
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

    public function setRateLimits(array $rateLimits): self
    {
        $this->options['rateLimits'] = $rateLimits;
        return $this;
    }

    public function setChannelConfiguration(array $channelConfiguration): self
    {
        $this->options['channelConfiguration'] = $channelConfiguration;
        return $this;
    }

    public function setAppHash(string $appHash): self
    {
        $this->options['appHash'] = $appHash;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateVerificationOptions ' . $options . ']';
    }
}