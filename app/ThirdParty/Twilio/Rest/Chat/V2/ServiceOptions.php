<?php

namespace Twilio\Rest\Chat\V2;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function update(string $friendlyName = Values::NONE, string $defaultServiceRoleSid = Values::NONE, string $defaultChannelRoleSid = Values::NONE, string $defaultChannelCreatorRoleSid = Values::NONE, bool $readStatusEnabled = Values::NONE, bool $reachabilityEnabled = Values::NONE, int $typingIndicatorTimeout = Values::NONE, int $consumptionReportInterval = Values::NONE, bool $notificationsNewMessageEnabled = Values::NONE, string $notificationsNewMessageTemplate = Values::NONE, string $notificationsNewMessageSound = Values::NONE, bool $notificationsNewMessageBadgeCountEnabled = Values::NONE, bool $notificationsAddedToChannelEnabled = Values::NONE, string $notificationsAddedToChannelTemplate = Values::NONE, string $notificationsAddedToChannelSound = Values::NONE, bool $notificationsRemovedFromChannelEnabled = Values::NONE, string $notificationsRemovedFromChannelTemplate = Values::NONE, string $notificationsRemovedFromChannelSound = Values::NONE, bool $notificationsInvitedToChannelEnabled = Values::NONE, string $notificationsInvitedToChannelTemplate = Values::NONE, string $notificationsInvitedToChannelSound = Values::NONE, string $preWebhookUrl = Values::NONE, string $postWebhookUrl = Values::NONE, string $webhookMethod = Values::NONE, array $webhookFilters = Values::ARRAY_NONE, int $limitsChannelMembers = Values::NONE, int $limitsUserChannels = Values::NONE, string $mediaCompatibilityMessage = Values::NONE, int $preWebhookRetryCount = Values::NONE, int $postWebhookRetryCount = Values::NONE, bool $notificationsLogEnabled = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($friendlyName, $defaultServiceRoleSid, $defaultChannelRoleSid, $defaultChannelCreatorRoleSid, $readStatusEnabled, $reachabilityEnabled, $typingIndicatorTimeout, $consumptionReportInterval, $notificationsNewMessageEnabled, $notificationsNewMessageTemplate, $notificationsNewMessageSound, $notificationsNewMessageBadgeCountEnabled, $notificationsAddedToChannelEnabled, $notificationsAddedToChannelTemplate, $notificationsAddedToChannelSound, $notificationsRemovedFromChannelEnabled, $notificationsRemovedFromChannelTemplate, $notificationsRemovedFromChannelSound, $notificationsInvitedToChannelEnabled, $notificationsInvitedToChannelTemplate, $notificationsInvitedToChannelSound, $preWebhookUrl, $postWebhookUrl, $webhookMethod, $webhookFilters, $limitsChannelMembers, $limitsUserChannels, $mediaCompatibilityMessage, $preWebhookRetryCount, $postWebhookRetryCount, $notificationsLogEnabled);
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $defaultServiceRoleSid = Values::NONE, string $defaultChannelRoleSid = Values::NONE, string $defaultChannelCreatorRoleSid = Values::NONE, bool $readStatusEnabled = Values::NONE, bool $reachabilityEnabled = Values::NONE, int $typingIndicatorTimeout = Values::NONE, int $consumptionReportInterval = Values::NONE, bool $notificationsNewMessageEnabled = Values::NONE, string $notificationsNewMessageTemplate = Values::NONE, string $notificationsNewMessageSound = Values::NONE, bool $notificationsNewMessageBadgeCountEnabled = Values::NONE, bool $notificationsAddedToChannelEnabled = Values::NONE, string $notificationsAddedToChannelTemplate = Values::NONE, string $notificationsAddedToChannelSound = Values::NONE, bool $notificationsRemovedFromChannelEnabled = Values::NONE, string $notificationsRemovedFromChannelTemplate = Values::NONE, string $notificationsRemovedFromChannelSound = Values::NONE, bool $notificationsInvitedToChannelEnabled = Values::NONE, string $notificationsInvitedToChannelTemplate = Values::NONE, string $notificationsInvitedToChannelSound = Values::NONE, string $preWebhookUrl = Values::NONE, string $postWebhookUrl = Values::NONE, string $webhookMethod = Values::NONE, array $webhookFilters = Values::ARRAY_NONE, int $limitsChannelMembers = Values::NONE, int $limitsUserChannels = Values::NONE, string $mediaCompatibilityMessage = Values::NONE, int $preWebhookRetryCount = Values::NONE, int $postWebhookRetryCount = Values::NONE, bool $notificationsLogEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['defaultServiceRoleSid'] = $defaultServiceRoleSid;
        $this->options['defaultChannelRoleSid'] = $defaultChannelRoleSid;
        $this->options['defaultChannelCreatorRoleSid'] = $defaultChannelCreatorRoleSid;
        $this->options['readStatusEnabled'] = $readStatusEnabled;
        $this->options['reachabilityEnabled'] = $reachabilityEnabled;
        $this->options['typingIndicatorTimeout'] = $typingIndicatorTimeout;
        $this->options['consumptionReportInterval'] = $consumptionReportInterval;
        $this->options['notificationsNewMessageEnabled'] = $notificationsNewMessageEnabled;
        $this->options['notificationsNewMessageTemplate'] = $notificationsNewMessageTemplate;
        $this->options['notificationsNewMessageSound'] = $notificationsNewMessageSound;
        $this->options['notificationsNewMessageBadgeCountEnabled'] = $notificationsNewMessageBadgeCountEnabled;
        $this->options['notificationsAddedToChannelEnabled'] = $notificationsAddedToChannelEnabled;
        $this->options['notificationsAddedToChannelTemplate'] = $notificationsAddedToChannelTemplate;
        $this->options['notificationsAddedToChannelSound'] = $notificationsAddedToChannelSound;
        $this->options['notificationsRemovedFromChannelEnabled'] = $notificationsRemovedFromChannelEnabled;
        $this->options['notificationsRemovedFromChannelTemplate'] = $notificationsRemovedFromChannelTemplate;
        $this->options['notificationsRemovedFromChannelSound'] = $notificationsRemovedFromChannelSound;
        $this->options['notificationsInvitedToChannelEnabled'] = $notificationsInvitedToChannelEnabled;
        $this->options['notificationsInvitedToChannelTemplate'] = $notificationsInvitedToChannelTemplate;
        $this->options['notificationsInvitedToChannelSound'] = $notificationsInvitedToChannelSound;
        $this->options['preWebhookUrl'] = $preWebhookUrl;
        $this->options['postWebhookUrl'] = $postWebhookUrl;
        $this->options['webhookMethod'] = $webhookMethod;
        $this->options['webhookFilters'] = $webhookFilters;
        $this->options['limitsChannelMembers'] = $limitsChannelMembers;
        $this->options['limitsUserChannels'] = $limitsUserChannels;
        $this->options['mediaCompatibilityMessage'] = $mediaCompatibilityMessage;
        $this->options['preWebhookRetryCount'] = $preWebhookRetryCount;
        $this->options['postWebhookRetryCount'] = $postWebhookRetryCount;
        $this->options['notificationsLogEnabled'] = $notificationsLogEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setDefaultServiceRoleSid(string $defaultServiceRoleSid): self
    {
        $this->options['defaultServiceRoleSid'] = $defaultServiceRoleSid;
        return $this;
    }

    public function setDefaultChannelRoleSid(string $defaultChannelRoleSid): self
    {
        $this->options['defaultChannelRoleSid'] = $defaultChannelRoleSid;
        return $this;
    }

    public function setDefaultChannelCreatorRoleSid(string $defaultChannelCreatorRoleSid): self
    {
        $this->options['defaultChannelCreatorRoleSid'] = $defaultChannelCreatorRoleSid;
        return $this;
    }

    public function setReadStatusEnabled(bool $readStatusEnabled): self
    {
        $this->options['readStatusEnabled'] = $readStatusEnabled;
        return $this;
    }

    public function setReachabilityEnabled(bool $reachabilityEnabled): self
    {
        $this->options['reachabilityEnabled'] = $reachabilityEnabled;
        return $this;
    }

    public function setTypingIndicatorTimeout(int $typingIndicatorTimeout): self
    {
        $this->options['typingIndicatorTimeout'] = $typingIndicatorTimeout;
        return $this;
    }

    public function setConsumptionReportInterval(int $consumptionReportInterval): self
    {
        $this->options['consumptionReportInterval'] = $consumptionReportInterval;
        return $this;
    }

    public function setNotificationsNewMessageEnabled(bool $notificationsNewMessageEnabled): self
    {
        $this->options['notificationsNewMessageEnabled'] = $notificationsNewMessageEnabled;
        return $this;
    }

    public function setNotificationsNewMessageTemplate(string $notificationsNewMessageTemplate): self
    {
        $this->options['notificationsNewMessageTemplate'] = $notificationsNewMessageTemplate;
        return $this;
    }

    public function setNotificationsNewMessageSound(string $notificationsNewMessageSound): self
    {
        $this->options['notificationsNewMessageSound'] = $notificationsNewMessageSound;
        return $this;
    }

    public function setNotificationsNewMessageBadgeCountEnabled(bool $notificationsNewMessageBadgeCountEnabled): self
    {
        $this->options['notificationsNewMessageBadgeCountEnabled'] = $notificationsNewMessageBadgeCountEnabled;
        return $this;
    }

    public function setNotificationsAddedToChannelEnabled(bool $notificationsAddedToChannelEnabled): self
    {
        $this->options['notificationsAddedToChannelEnabled'] = $notificationsAddedToChannelEnabled;
        return $this;
    }

    public function setNotificationsAddedToChannelTemplate(string $notificationsAddedToChannelTemplate): self
    {
        $this->options['notificationsAddedToChannelTemplate'] = $notificationsAddedToChannelTemplate;
        return $this;
    }

    public function setNotificationsAddedToChannelSound(string $notificationsAddedToChannelSound): self
    {
        $this->options['notificationsAddedToChannelSound'] = $notificationsAddedToChannelSound;
        return $this;
    }

    public function setNotificationsRemovedFromChannelEnabled(bool $notificationsRemovedFromChannelEnabled): self
    {
        $this->options['notificationsRemovedFromChannelEnabled'] = $notificationsRemovedFromChannelEnabled;
        return $this;
    }

    public function setNotificationsRemovedFromChannelTemplate(string $notificationsRemovedFromChannelTemplate): self
    {
        $this->options['notificationsRemovedFromChannelTemplate'] = $notificationsRemovedFromChannelTemplate;
        return $this;
    }

    public function setNotificationsRemovedFromChannelSound(string $notificationsRemovedFromChannelSound): self
    {
        $this->options['notificationsRemovedFromChannelSound'] = $notificationsRemovedFromChannelSound;
        return $this;
    }

    public function setNotificationsInvitedToChannelEnabled(bool $notificationsInvitedToChannelEnabled): self
    {
        $this->options['notificationsInvitedToChannelEnabled'] = $notificationsInvitedToChannelEnabled;
        return $this;
    }

    public function setNotificationsInvitedToChannelTemplate(string $notificationsInvitedToChannelTemplate): self
    {
        $this->options['notificationsInvitedToChannelTemplate'] = $notificationsInvitedToChannelTemplate;
        return $this;
    }

    public function setNotificationsInvitedToChannelSound(string $notificationsInvitedToChannelSound): self
    {
        $this->options['notificationsInvitedToChannelSound'] = $notificationsInvitedToChannelSound;
        return $this;
    }

    public function setPreWebhookUrl(string $preWebhookUrl): self
    {
        $this->options['preWebhookUrl'] = $preWebhookUrl;
        return $this;
    }

    public function setPostWebhookUrl(string $postWebhookUrl): self
    {
        $this->options['postWebhookUrl'] = $postWebhookUrl;
        return $this;
    }

    public function setWebhookMethod(string $webhookMethod): self
    {
        $this->options['webhookMethod'] = $webhookMethod;
        return $this;
    }

    public function setWebhookFilters(array $webhookFilters): self
    {
        $this->options['webhookFilters'] = $webhookFilters;
        return $this;
    }

    public function setLimitsChannelMembers(int $limitsChannelMembers): self
    {
        $this->options['limitsChannelMembers'] = $limitsChannelMembers;
        return $this;
    }

    public function setLimitsUserChannels(int $limitsUserChannels): self
    {
        $this->options['limitsUserChannels'] = $limitsUserChannels;
        return $this;
    }

    public function setMediaCompatibilityMessage(string $mediaCompatibilityMessage): self
    {
        $this->options['mediaCompatibilityMessage'] = $mediaCompatibilityMessage;
        return $this;
    }

    public function setPreWebhookRetryCount(int $preWebhookRetryCount): self
    {
        $this->options['preWebhookRetryCount'] = $preWebhookRetryCount;
        return $this;
    }

    public function setPostWebhookRetryCount(int $postWebhookRetryCount): self
    {
        $this->options['postWebhookRetryCount'] = $postWebhookRetryCount;
        return $this;
    }

    public function setNotificationsLogEnabled(bool $notificationsLogEnabled): self
    {
        $this->options['notificationsLogEnabled'] = $notificationsLogEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V2.UpdateServiceOptions ' . $options . ']';
    }
}