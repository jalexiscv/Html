<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FactorOptions
{
    public static function create(string $bindingAlg = Values::NONE, string $bindingPublicKey = Values::NONE, string $configAppId = Values::NONE, string $configNotificationPlatform = Values::NONE, string $configNotificationToken = Values::NONE, string $configSdkVersion = Values::NONE): CreateFactorOptions
    {
        return new CreateFactorOptions($bindingAlg, $bindingPublicKey, $configAppId, $configNotificationPlatform, $configNotificationToken, $configSdkVersion);
    }

    public static function update(string $authPayload = Values::NONE, string $friendlyName = Values::NONE, string $configNotificationToken = Values::NONE, string $configSdkVersion = Values::NONE): UpdateFactorOptions
    {
        return new UpdateFactorOptions($authPayload, $friendlyName, $configNotificationToken, $configSdkVersion);
    }
}

class CreateFactorOptions extends Options
{
    public function __construct(string $bindingAlg = Values::NONE, string $bindingPublicKey = Values::NONE, string $configAppId = Values::NONE, string $configNotificationPlatform = Values::NONE, string $configNotificationToken = Values::NONE, string $configSdkVersion = Values::NONE)
    {
        $this->options['bindingAlg'] = $bindingAlg;
        $this->options['bindingPublicKey'] = $bindingPublicKey;
        $this->options['configAppId'] = $configAppId;
        $this->options['configNotificationPlatform'] = $configNotificationPlatform;
        $this->options['configNotificationToken'] = $configNotificationToken;
        $this->options['configSdkVersion'] = $configSdkVersion;
    }

    public function setBindingAlg(string $bindingAlg): self
    {
        $this->options['bindingAlg'] = $bindingAlg;
        return $this;
    }

    public function setBindingPublicKey(string $bindingPublicKey): self
    {
        $this->options['bindingPublicKey'] = $bindingPublicKey;
        return $this;
    }

    public function setConfigAppId(string $configAppId): self
    {
        $this->options['configAppId'] = $configAppId;
        return $this;
    }

    public function setConfigNotificationPlatform(string $configNotificationPlatform): self
    {
        $this->options['configNotificationPlatform'] = $configNotificationPlatform;
        return $this;
    }

    public function setConfigNotificationToken(string $configNotificationToken): self
    {
        $this->options['configNotificationToken'] = $configNotificationToken;
        return $this;
    }

    public function setConfigSdkVersion(string $configSdkVersion): self
    {
        $this->options['configSdkVersion'] = $configSdkVersion;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateFactorOptions ' . $options . ']';
    }
}

class UpdateFactorOptions extends Options
{
    public function __construct(string $authPayload = Values::NONE, string $friendlyName = Values::NONE, string $configNotificationToken = Values::NONE, string $configSdkVersion = Values::NONE)
    {
        $this->options['authPayload'] = $authPayload;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['configNotificationToken'] = $configNotificationToken;
        $this->options['configSdkVersion'] = $configSdkVersion;
    }

    public function setAuthPayload(string $authPayload): self
    {
        $this->options['authPayload'] = $authPayload;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setConfigNotificationToken(string $configNotificationToken): self
    {
        $this->options['configNotificationToken'] = $configNotificationToken;
        return $this;
    }

    public function setConfigSdkVersion(string $configSdkVersion): self
    {
        $this->options['configSdkVersion'] = $configSdkVersion;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.UpdateFactorOptions ' . $options . ']';
    }
}