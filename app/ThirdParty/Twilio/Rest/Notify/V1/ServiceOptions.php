<?php

namespace Twilio\Rest\Notify\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function create(string $friendlyName = Values::NONE, string $apnCredentialSid = Values::NONE, string $gcmCredentialSid = Values::NONE, string $messagingServiceSid = Values::NONE, string $facebookMessengerPageId = Values::NONE, string $defaultApnNotificationProtocolVersion = Values::NONE, string $defaultGcmNotificationProtocolVersion = Values::NONE, string $fcmCredentialSid = Values::NONE, string $defaultFcmNotificationProtocolVersion = Values::NONE, bool $logEnabled = Values::NONE, string $alexaSkillId = Values::NONE, string $defaultAlexaNotificationProtocolVersion = Values::NONE, string $deliveryCallbackUrl = Values::NONE, bool $deliveryCallbackEnabled = Values::NONE): CreateServiceOptions
    {
        return new CreateServiceOptions($friendlyName, $apnCredentialSid, $gcmCredentialSid, $messagingServiceSid, $facebookMessengerPageId, $defaultApnNotificationProtocolVersion, $defaultGcmNotificationProtocolVersion, $fcmCredentialSid, $defaultFcmNotificationProtocolVersion, $logEnabled, $alexaSkillId, $defaultAlexaNotificationProtocolVersion, $deliveryCallbackUrl, $deliveryCallbackEnabled);
    }

    public static function read(string $friendlyName = Values::NONE): ReadServiceOptions
    {
        return new ReadServiceOptions($friendlyName);
    }

    public static function update(string $friendlyName = Values::NONE, string $apnCredentialSid = Values::NONE, string $gcmCredentialSid = Values::NONE, string $messagingServiceSid = Values::NONE, string $facebookMessengerPageId = Values::NONE, string $defaultApnNotificationProtocolVersion = Values::NONE, string $defaultGcmNotificationProtocolVersion = Values::NONE, string $fcmCredentialSid = Values::NONE, string $defaultFcmNotificationProtocolVersion = Values::NONE, bool $logEnabled = Values::NONE, string $alexaSkillId = Values::NONE, string $defaultAlexaNotificationProtocolVersion = Values::NONE, string $deliveryCallbackUrl = Values::NONE, bool $deliveryCallbackEnabled = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($friendlyName, $apnCredentialSid, $gcmCredentialSid, $messagingServiceSid, $facebookMessengerPageId, $defaultApnNotificationProtocolVersion, $defaultGcmNotificationProtocolVersion, $fcmCredentialSid, $defaultFcmNotificationProtocolVersion, $logEnabled, $alexaSkillId, $defaultAlexaNotificationProtocolVersion, $deliveryCallbackUrl, $deliveryCallbackEnabled);
    }
}

class CreateServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $apnCredentialSid = Values::NONE, string $gcmCredentialSid = Values::NONE, string $messagingServiceSid = Values::NONE, string $facebookMessengerPageId = Values::NONE, string $defaultApnNotificationProtocolVersion = Values::NONE, string $defaultGcmNotificationProtocolVersion = Values::NONE, string $fcmCredentialSid = Values::NONE, string $defaultFcmNotificationProtocolVersion = Values::NONE, bool $logEnabled = Values::NONE, string $alexaSkillId = Values::NONE, string $defaultAlexaNotificationProtocolVersion = Values::NONE, string $deliveryCallbackUrl = Values::NONE, bool $deliveryCallbackEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        $this->options['logEnabled'] = $logEnabled;
        $this->options['alexaSkillId'] = $alexaSkillId;
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
        $this->options['deliveryCallbackUrl'] = $deliveryCallbackUrl;
        $this->options['deliveryCallbackEnabled'] = $deliveryCallbackEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setApnCredentialSid(string $apnCredentialSid): self
    {
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        return $this;
    }

    public function setGcmCredentialSid(string $gcmCredentialSid): self
    {
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        return $this;
    }

    public function setMessagingServiceSid(string $messagingServiceSid): self
    {
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        return $this;
    }

    public function setFacebookMessengerPageId(string $facebookMessengerPageId): self
    {
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        return $this;
    }

    public function setDefaultApnNotificationProtocolVersion(string $defaultApnNotificationProtocolVersion): self
    {
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        return $this;
    }

    public function setDefaultGcmNotificationProtocolVersion(string $defaultGcmNotificationProtocolVersion): self
    {
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        return $this;
    }

    public function setFcmCredentialSid(string $fcmCredentialSid): self
    {
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        return $this;
    }

    public function setDefaultFcmNotificationProtocolVersion(string $defaultFcmNotificationProtocolVersion): self
    {
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        return $this;
    }

    public function setLogEnabled(bool $logEnabled): self
    {
        $this->options['logEnabled'] = $logEnabled;
        return $this;
    }

    public function setAlexaSkillId(string $alexaSkillId): self
    {
        $this->options['alexaSkillId'] = $alexaSkillId;
        return $this;
    }

    public function setDefaultAlexaNotificationProtocolVersion(string $defaultAlexaNotificationProtocolVersion): self
    {
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
        return $this;
    }

    public function setDeliveryCallbackUrl(string $deliveryCallbackUrl): self
    {
        $this->options['deliveryCallbackUrl'] = $deliveryCallbackUrl;
        return $this;
    }

    public function setDeliveryCallbackEnabled(bool $deliveryCallbackEnabled): self
    {
        $this->options['deliveryCallbackEnabled'] = $deliveryCallbackEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Notify.V1.CreateServiceOptions ' . $options . ']';
    }
}

class ReadServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Notify.V1.ReadServiceOptions ' . $options . ']';
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $apnCredentialSid = Values::NONE, string $gcmCredentialSid = Values::NONE, string $messagingServiceSid = Values::NONE, string $facebookMessengerPageId = Values::NONE, string $defaultApnNotificationProtocolVersion = Values::NONE, string $defaultGcmNotificationProtocolVersion = Values::NONE, string $fcmCredentialSid = Values::NONE, string $defaultFcmNotificationProtocolVersion = Values::NONE, bool $logEnabled = Values::NONE, string $alexaSkillId = Values::NONE, string $defaultAlexaNotificationProtocolVersion = Values::NONE, string $deliveryCallbackUrl = Values::NONE, bool $deliveryCallbackEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        $this->options['logEnabled'] = $logEnabled;
        $this->options['alexaSkillId'] = $alexaSkillId;
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
        $this->options['deliveryCallbackUrl'] = $deliveryCallbackUrl;
        $this->options['deliveryCallbackEnabled'] = $deliveryCallbackEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setApnCredentialSid(string $apnCredentialSid): self
    {
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        return $this;
    }

    public function setGcmCredentialSid(string $gcmCredentialSid): self
    {
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        return $this;
    }

    public function setMessagingServiceSid(string $messagingServiceSid): self
    {
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        return $this;
    }

    public function setFacebookMessengerPageId(string $facebookMessengerPageId): self
    {
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        return $this;
    }

    public function setDefaultApnNotificationProtocolVersion(string $defaultApnNotificationProtocolVersion): self
    {
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        return $this;
    }

    public function setDefaultGcmNotificationProtocolVersion(string $defaultGcmNotificationProtocolVersion): self
    {
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        return $this;
    }

    public function setFcmCredentialSid(string $fcmCredentialSid): self
    {
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        return $this;
    }

    public function setDefaultFcmNotificationProtocolVersion(string $defaultFcmNotificationProtocolVersion): self
    {
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        return $this;
    }

    public function setLogEnabled(bool $logEnabled): self
    {
        $this->options['logEnabled'] = $logEnabled;
        return $this;
    }

    public function setAlexaSkillId(string $alexaSkillId): self
    {
        $this->options['alexaSkillId'] = $alexaSkillId;
        return $this;
    }

    public function setDefaultAlexaNotificationProtocolVersion(string $defaultAlexaNotificationProtocolVersion): self
    {
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
        return $this;
    }

    public function setDeliveryCallbackUrl(string $deliveryCallbackUrl): self
    {
        $this->options['deliveryCallbackUrl'] = $deliveryCallbackUrl;
        return $this;
    }

    public function setDeliveryCallbackEnabled(bool $deliveryCallbackEnabled): self
    {
        $this->options['deliveryCallbackEnabled'] = $deliveryCallbackEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Notify.V1.UpdateServiceOptions ' . $options . ']';
    }
}