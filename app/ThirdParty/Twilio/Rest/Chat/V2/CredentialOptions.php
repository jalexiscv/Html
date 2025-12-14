<?php

namespace Twilio\Rest\Chat\V2;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CredentialOptions
{
    public static function create(string $friendlyName = Values::NONE, string $certificate = Values::NONE, string $privateKey = Values::NONE, bool $sandbox = Values::NONE, string $apiKey = Values::NONE, string $secret = Values::NONE): CreateCredentialOptions
    {
        return new CreateCredentialOptions($friendlyName, $certificate, $privateKey, $sandbox, $apiKey, $secret);
    }

    public static function update(string $friendlyName = Values::NONE, string $certificate = Values::NONE, string $privateKey = Values::NONE, bool $sandbox = Values::NONE, string $apiKey = Values::NONE, string $secret = Values::NONE): UpdateCredentialOptions
    {
        return new UpdateCredentialOptions($friendlyName, $certificate, $privateKey, $sandbox, $apiKey, $secret);
    }
}

class CreateCredentialOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $certificate = Values::NONE, string $privateKey = Values::NONE, bool $sandbox = Values::NONE, string $apiKey = Values::NONE, string $secret = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['certificate'] = $certificate;
        $this->options['privateKey'] = $privateKey;
        $this->options['sandbox'] = $sandbox;
        $this->options['apiKey'] = $apiKey;
        $this->options['secret'] = $secret;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setCertificate(string $certificate): self
    {
        $this->options['certificate'] = $certificate;
        return $this;
    }

    public function setPrivateKey(string $privateKey): self
    {
        $this->options['privateKey'] = $privateKey;
        return $this;
    }

    public function setSandbox(bool $sandbox): self
    {
        $this->options['sandbox'] = $sandbox;
        return $this;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->options['apiKey'] = $apiKey;
        return $this;
    }

    public function setSecret(string $secret): self
    {
        $this->options['secret'] = $secret;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.CreateCredentialOptions ' . $options . ']';
    }
}

class UpdateCredentialOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $certificate = Values::NONE, string $privateKey = Values::NONE, bool $sandbox = Values::NONE, string $apiKey = Values::NONE, string $secret = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['certificate'] = $certificate;
        $this->options['privateKey'] = $privateKey;
        $this->options['sandbox'] = $sandbox;
        $this->options['apiKey'] = $apiKey;
        $this->options['secret'] = $secret;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setCertificate(string $certificate): self
    {
        $this->options['certificate'] = $certificate;
        return $this;
    }

    public function setPrivateKey(string $privateKey): self
    {
        $this->options['privateKey'] = $privateKey;
        return $this;
    }

    public function setSandbox(bool $sandbox): self
    {
        $this->options['sandbox'] = $sandbox;
        return $this;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->options['apiKey'] = $apiKey;
        return $this;
    }

    public function setSecret(string $secret): self
    {
        $this->options['secret'] = $secret;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.UpdateCredentialOptions ' . $options . ']';
    }
}