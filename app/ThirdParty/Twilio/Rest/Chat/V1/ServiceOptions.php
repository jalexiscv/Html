<?php

namespace Twilio\Rest\Chat\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function update(string $friendlyName = Values::NONE, string $defaultServiceRoleSid = Values::NONE, string $defaultChannelRoleSid = Values::NONE, string $defaultChannelCreatorRoleSid = Values::NONE, bool $readStatusEnabled = Values::NONE, bool $reachabilityEnabled = Values::NONE, int $typingIndicatorTimeout = Values::NONE, int $consumptionReportInterval = Values::NONE, bool $notificationsNewMessageEnabled = Values::NONE, string $notificationsNewMessageTemplate = Values::NONE, bool $notificationsAddedToChannelEnabled = Values::NONE, string $notificationsAddedToChannelTemplate = Values::NONE, bool $notificationsRemovedFromChannelEnabled = Values::NONE, string $notificationsRemovedFromChannelTemplate = Values::NONE, bool $notificationsInvitedToChannelEnabled = Values::NONE, string $notificationsInvitedToChannelTemplate = Values::NONE, string $preWebhookUrl = Values::NONE, string $postWebhookUrl = Values::NONE, string $webhookMethod = Values::NONE, array $webhookFilters = Values::ARRAY_NONE, string $webhooksOnMessageSendUrl = Values::NONE, string $webhooksOnMessageSendMethod = Values::NONE, string $webhooksOnMessageUpdateUrl = Values::NONE, string $webhooksOnMessageUpdateMethod = Values::NONE, string $webhooksOnMessageRemoveUrl = Values::NONE, string $webhooksOnMessageRemoveMethod = Values::NONE, string $webhooksOnChannelAddUrl = Values::NONE, string $webhooksOnChannelAddMethod = Values::NONE, string $webhooksOnChannelDestroyUrl = Values::NONE, string $webhooksOnChannelDestroyMethod = Values::NONE, string $webhooksOnChannelUpdateUrl = Values::NONE, string $webhooksOnChannelUpdateMethod = Values::NONE, string $webhooksOnMemberAddUrl = Values::NONE, string $webhooksOnMemberAddMethod = Values::NONE, string $webhooksOnMemberRemoveUrl = Values::NONE, string $webhooksOnMemberRemoveMethod = Values::NONE, string $webhooksOnMessageSentUrl = Values::NONE, string $webhooksOnMessageSentMethod = Values::NONE, string $webhooksOnMessageUpdatedUrl = Values::NONE, string $webhooksOnMessageUpdatedMethod = Values::NONE, string $webhooksOnMessageRemovedUrl = Values::NONE, string $webhooksOnMessageRemovedMethod = Values::NONE, string $webhooksOnChannelAddedUrl = Values::NONE, string $webhooksOnChannelAddedMethod = Values::NONE, string $webhooksOnChannelDestroyedUrl = Values::NONE, string $webhooksOnChannelDestroyedMethod = Values::NONE, string $webhooksOnChannelUpdatedUrl = Values::NONE, string $webhooksOnChannelUpdatedMethod = Values::NONE, string $webhooksOnMemberAddedUrl = Values::NONE, string $webhooksOnMemberAddedMethod = Values::NONE, string $webhooksOnMemberRemovedUrl = Values::NONE, string $webhooksOnMemberRemovedMethod = Values::NONE, int $limitsChannelMembers = Values::NONE, int $limitsUserChannels = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($friendlyName, $defaultServiceRoleSid, $defaultChannelRoleSid, $defaultChannelCreatorRoleSid, $readStatusEnabled, $reachabilityEnabled, $typingIndicatorTimeout, $consumptionReportInterval, $notificationsNewMessageEnabled, $notificationsNewMessageTemplate, $notificationsAddedToChannelEnabled, $notificationsAddedToChannelTemplate, $notificationsRemovedFromChannelEnabled, $notificationsRemovedFromChannelTemplate, $notificationsInvitedToChannelEnabled, $notificationsInvitedToChannelTemplate, $preWebhookUrl, $postWebhookUrl, $webhookMethod, $webhookFilters, $webhooksOnMessageSendUrl, $webhooksOnMessageSendMethod, $webhooksOnMessageUpdateUrl, $webhooksOnMessageUpdateMethod, $webhooksOnMessageRemoveUrl, $webhooksOnMessageRemoveMethod, $webhooksOnChannelAddUrl, $webhooksOnChannelAddMethod, $webhooksOnChannelDestroyUrl, $webhooksOnChannelDestroyMethod, $webhooksOnChannelUpdateUrl, $webhooksOnChannelUpdateMethod, $webhooksOnMemberAddUrl, $webhooksOnMemberAddMethod, $webhooksOnMemberRemoveUrl, $webhooksOnMemberRemoveMethod, $webhooksOnMessageSentUrl, $webhooksOnMessageSentMethod, $webhooksOnMessageUpdatedUrl, $webhooksOnMessageUpdatedMethod, $webhooksOnMessageRemovedUrl, $webhooksOnMessageRemovedMethod, $webhooksOnChannelAddedUrl, $webhooksOnChannelAddedMethod, $webhooksOnChannelDestroyedUrl, $webhooksOnChannelDestroyedMethod, $webhooksOnChannelUpdatedUrl, $webhooksOnChannelUpdatedMethod, $webhooksOnMemberAddedUrl, $webhooksOnMemberAddedMethod, $webhooksOnMemberRemovedUrl, $webhooksOnMemberRemovedMethod, $limitsChannelMembers, $limitsUserChannels);
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $defaultServiceRoleSid = Values::NONE, string $defaultChannelRoleSid = Values::NONE, string $defaultChannelCreatorRoleSid = Values::NONE, bool $readStatusEnabled = Values::NONE, bool $reachabilityEnabled = Values::NONE, int $typingIndicatorTimeout = Values::NONE, int $consumptionReportInterval = Values::NONE, bool $notificationsNewMessageEnabled = Values::NONE, string $notificationsNewMessageTemplate = Values::NONE, bool $notificationsAddedToChannelEnabled = Values::NONE, string $notificationsAddedToChannelTemplate = Values::NONE, bool $notificationsRemovedFromChannelEnabled = Values::NONE, string $notificationsRemovedFromChannelTemplate = Values::NONE, bool $notificationsInvitedToChannelEnabled = Values::NONE, string $notificationsInvitedToChannelTemplate = Values::NONE, string $preWebhookUrl = Values::NONE, string $postWebhookUrl = Values::NONE, string $webhookMethod = Values::NONE, array $webhookFilters = Values::ARRAY_NONE, string $webhooksOnMessageSendUrl = Values::NONE, string $webhooksOnMessageSendMethod = Values::NONE, string $webhooksOnMessageUpdateUrl = Values::NONE, string $webhooksOnMessageUpdateMethod = Values::NONE, string $webhooksOnMessageRemoveUrl = Values::NONE, string $webhooksOnMessageRemoveMethod = Values::NONE, string $webhooksOnChannelAddUrl = Values::NONE, string $webhooksOnChannelAddMethod = Values::NONE, string $webhooksOnChannelDestroyUrl = Values::NONE, string $webhooksOnChannelDestroyMethod = Values::NONE, string $webhooksOnChannelUpdateUrl = Values::NONE, string $webhooksOnChannelUpdateMethod = Values::NONE, string $webhooksOnMemberAddUrl = Values::NONE, string $webhooksOnMemberAddMethod = Values::NONE, string $webhooksOnMemberRemoveUrl = Values::NONE, string $webhooksOnMemberRemoveMethod = Values::NONE, string $webhooksOnMessageSentUrl = Values::NONE, string $webhooksOnMessageSentMethod = Values::NONE, string $webhooksOnMessageUpdatedUrl = Values::NONE, string $webhooksOnMessageUpdatedMethod = Values::NONE, string $webhooksOnMessageRemovedUrl = Values::NONE, string $webhooksOnMessageRemovedMethod = Values::NONE, string $webhooksOnChannelAddedUrl = Values::NONE, string $webhooksOnChannelAddedMethod = Values::NONE, string $webhooksOnChannelDestroyedUrl = Values::NONE, string $webhooksOnChannelDestroyedMethod = Values::NONE, string $webhooksOnChannelUpdatedUrl = Values::NONE, string $webhooksOnChannelUpdatedMethod = Values::NONE, string $webhooksOnMemberAddedUrl = Values::NONE, string $webhooksOnMemberAddedMethod = Values::NONE, string $webhooksOnMemberRemovedUrl = Values::NONE, string $webhooksOnMemberRemovedMethod = Values::NONE, int $limitsChannelMembers = Values::NONE, int $limitsUserChannels = Values::NONE)
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
        $this->options['notificationsAddedToChannelEnabled'] = $notificationsAddedToChannelEnabled;
        $this->options['notificationsAddedToChannelTemplate'] = $notificationsAddedToChannelTemplate;
        $this->options['notificationsRemovedFromChannelEnabled'] = $notificationsRemovedFromChannelEnabled;
        $this->options['notificationsRemovedFromChannelTemplate'] = $notificationsRemovedFromChannelTemplate;
        $this->options['notificationsInvitedToChannelEnabled'] = $notificationsInvitedToChannelEnabled;
        $this->options['notificationsInvitedToChannelTemplate'] = $notificationsInvitedToChannelTemplate;
        $this->options['preWebhookUrl'] = $preWebhookUrl;
        $this->options['postWebhookUrl'] = $postWebhookUrl;
        $this->options['webhookMethod'] = $webhookMethod;
        $this->options['webhookFilters'] = $webhookFilters;
        $this->options['webhooksOnMessageSendUrl'] = $webhooksOnMessageSendUrl;
        $this->options['webhooksOnMessageSendMethod'] = $webhooksOnMessageSendMethod;
        $this->options['webhooksOnMessageUpdateUrl'] = $webhooksOnMessageUpdateUrl;
        $this->options['webhooksOnMessageUpdateMethod'] = $webhooksOnMessageUpdateMethod;
        $this->options['webhooksOnMessageRemoveUrl'] = $webhooksOnMessageRemoveUrl;
        $this->options['webhooksOnMessageRemoveMethod'] = $webhooksOnMessageRemoveMethod;
        $this->options['webhooksOnChannelAddUrl'] = $webhooksOnChannelAddUrl;
        $this->options['webhooksOnChannelAddMethod'] = $webhooksOnChannelAddMethod;
        $this->options['webhooksOnChannelDestroyUrl'] = $webhooksOnChannelDestroyUrl;
        $this->options['webhooksOnChannelDestroyMethod'] = $webhooksOnChannelDestroyMethod;
        $this->options['webhooksOnChannelUpdateUrl'] = $webhooksOnChannelUpdateUrl;
        $this->options['webhooksOnChannelUpdateMethod'] = $webhooksOnChannelUpdateMethod;
        $this->options['webhooksOnMemberAddUrl'] = $webhooksOnMemberAddUrl;
        $this->options['webhooksOnMemberAddMethod'] = $webhooksOnMemberAddMethod;
        $this->options['webhooksOnMemberRemoveUrl'] = $webhooksOnMemberRemoveUrl;
        $this->options['webhooksOnMemberRemoveMethod'] = $webhooksOnMemberRemoveMethod;
        $this->options['webhooksOnMessageSentUrl'] = $webhooksOnMessageSentUrl;
        $this->options['webhooksOnMessageSentMethod'] = $webhooksOnMessageSentMethod;
        $this->options['webhooksOnMessageUpdatedUrl'] = $webhooksOnMessageUpdatedUrl;
        $this->options['webhooksOnMessageUpdatedMethod'] = $webhooksOnMessageUpdatedMethod;
        $this->options['webhooksOnMessageRemovedUrl'] = $webhooksOnMessageRemovedUrl;
        $this->options['webhooksOnMessageRemovedMethod'] = $webhooksOnMessageRemovedMethod;
        $this->options['webhooksOnChannelAddedUrl'] = $webhooksOnChannelAddedUrl;
        $this->options['webhooksOnChannelAddedMethod'] = $webhooksOnChannelAddedMethod;
        $this->options['webhooksOnChannelDestroyedUrl'] = $webhooksOnChannelDestroyedUrl;
        $this->options['webhooksOnChannelDestroyedMethod'] = $webhooksOnChannelDestroyedMethod;
        $this->options['webhooksOnChannelUpdatedUrl'] = $webhooksOnChannelUpdatedUrl;
        $this->options['webhooksOnChannelUpdatedMethod'] = $webhooksOnChannelUpdatedMethod;
        $this->options['webhooksOnMemberAddedUrl'] = $webhooksOnMemberAddedUrl;
        $this->options['webhooksOnMemberAddedMethod'] = $webhooksOnMemberAddedMethod;
        $this->options['webhooksOnMemberRemovedUrl'] = $webhooksOnMemberRemovedUrl;
        $this->options['webhooksOnMemberRemovedMethod'] = $webhooksOnMemberRemovedMethod;
        $this->options['limitsChannelMembers'] = $limitsChannelMembers;
        $this->options['limitsUserChannels'] = $limitsUserChannels;
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

    public function setWebhooksOnMessageSendUrl(string $webhooksOnMessageSendUrl): self
    {
        $this->options['webhooksOnMessageSendUrl'] = $webhooksOnMessageSendUrl;
        return $this;
    }

    public function setWebhooksOnMessageSendMethod(string $webhooksOnMessageSendMethod): self
    {
        $this->options['webhooksOnMessageSendMethod'] = $webhooksOnMessageSendMethod;
        return $this;
    }

    public function setWebhooksOnMessageUpdateUrl(string $webhooksOnMessageUpdateUrl): self
    {
        $this->options['webhooksOnMessageUpdateUrl'] = $webhooksOnMessageUpdateUrl;
        return $this;
    }

    public function setWebhooksOnMessageUpdateMethod(string $webhooksOnMessageUpdateMethod): self
    {
        $this->options['webhooksOnMessageUpdateMethod'] = $webhooksOnMessageUpdateMethod;
        return $this;
    }

    public function setWebhooksOnMessageRemoveUrl(string $webhooksOnMessageRemoveUrl): self
    {
        $this->options['webhooksOnMessageRemoveUrl'] = $webhooksOnMessageRemoveUrl;
        return $this;
    }

    public function setWebhooksOnMessageRemoveMethod(string $webhooksOnMessageRemoveMethod): self
    {
        $this->options['webhooksOnMessageRemoveMethod'] = $webhooksOnMessageRemoveMethod;
        return $this;
    }

    public function setWebhooksOnChannelAddUrl(string $webhooksOnChannelAddUrl): self
    {
        $this->options['webhooksOnChannelAddUrl'] = $webhooksOnChannelAddUrl;
        return $this;
    }

    public function setWebhooksOnChannelAddMethod(string $webhooksOnChannelAddMethod): self
    {
        $this->options['webhooksOnChannelAddMethod'] = $webhooksOnChannelAddMethod;
        return $this;
    }

    public function setWebhooksOnChannelDestroyUrl(string $webhooksOnChannelDestroyUrl): self
    {
        $this->options['webhooksOnChannelDestroyUrl'] = $webhooksOnChannelDestroyUrl;
        return $this;
    }

    public function setWebhooksOnChannelDestroyMethod(string $webhooksOnChannelDestroyMethod): self
    {
        $this->options['webhooksOnChannelDestroyMethod'] = $webhooksOnChannelDestroyMethod;
        return $this;
    }

    public function setWebhooksOnChannelUpdateUrl(string $webhooksOnChannelUpdateUrl): self
    {
        $this->options['webhooksOnChannelUpdateUrl'] = $webhooksOnChannelUpdateUrl;
        return $this;
    }

    public function setWebhooksOnChannelUpdateMethod(string $webhooksOnChannelUpdateMethod): self
    {
        $this->options['webhooksOnChannelUpdateMethod'] = $webhooksOnChannelUpdateMethod;
        return $this;
    }

    public function setWebhooksOnMemberAddUrl(string $webhooksOnMemberAddUrl): self
    {
        $this->options['webhooksOnMemberAddUrl'] = $webhooksOnMemberAddUrl;
        return $this;
    }

    public function setWebhooksOnMemberAddMethod(string $webhooksOnMemberAddMethod): self
    {
        $this->options['webhooksOnMemberAddMethod'] = $webhooksOnMemberAddMethod;
        return $this;
    }

    public function setWebhooksOnMemberRemoveUrl(string $webhooksOnMemberRemoveUrl): self
    {
        $this->options['webhooksOnMemberRemoveUrl'] = $webhooksOnMemberRemoveUrl;
        return $this;
    }

    public function setWebhooksOnMemberRemoveMethod(string $webhooksOnMemberRemoveMethod): self
    {
        $this->options['webhooksOnMemberRemoveMethod'] = $webhooksOnMemberRemoveMethod;
        return $this;
    }

    public function setWebhooksOnMessageSentUrl(string $webhooksOnMessageSentUrl): self
    {
        $this->options['webhooksOnMessageSentUrl'] = $webhooksOnMessageSentUrl;
        return $this;
    }

    public function setWebhooksOnMessageSentMethod(string $webhooksOnMessageSentMethod): self
    {
        $this->options['webhooksOnMessageSentMethod'] = $webhooksOnMessageSentMethod;
        return $this;
    }

    public function setWebhooksOnMessageUpdatedUrl(string $webhooksOnMessageUpdatedUrl): self
    {
        $this->options['webhooksOnMessageUpdatedUrl'] = $webhooksOnMessageUpdatedUrl;
        return $this;
    }

    public function setWebhooksOnMessageUpdatedMethod(string $webhooksOnMessageUpdatedMethod): self
    {
        $this->options['webhooksOnMessageUpdatedMethod'] = $webhooksOnMessageUpdatedMethod;
        return $this;
    }

    public function setWebhooksOnMessageRemovedUrl(string $webhooksOnMessageRemovedUrl): self
    {
        $this->options['webhooksOnMessageRemovedUrl'] = $webhooksOnMessageRemovedUrl;
        return $this;
    }

    public function setWebhooksOnMessageRemovedMethod(string $webhooksOnMessageRemovedMethod): self
    {
        $this->options['webhooksOnMessageRemovedMethod'] = $webhooksOnMessageRemovedMethod;
        return $this;
    }

    public function setWebhooksOnChannelAddedUrl(string $webhooksOnChannelAddedUrl): self
    {
        $this->options['webhooksOnChannelAddedUrl'] = $webhooksOnChannelAddedUrl;
        return $this;
    }

    public function setWebhooksOnChannelAddedMethod(string $webhooksOnChannelAddedMethod): self
    {
        $this->options['webhooksOnChannelAddedMethod'] = $webhooksOnChannelAddedMethod;
        return $this;
    }

    public function setWebhooksOnChannelDestroyedUrl(string $webhooksOnChannelDestroyedUrl): self
    {
        $this->options['webhooksOnChannelDestroyedUrl'] = $webhooksOnChannelDestroyedUrl;
        return $this;
    }

    public function setWebhooksOnChannelDestroyedMethod(string $webhooksOnChannelDestroyedMethod): self
    {
        $this->options['webhooksOnChannelDestroyedMethod'] = $webhooksOnChannelDestroyedMethod;
        return $this;
    }

    public function setWebhooksOnChannelUpdatedUrl(string $webhooksOnChannelUpdatedUrl): self
    {
        $this->options['webhooksOnChannelUpdatedUrl'] = $webhooksOnChannelUpdatedUrl;
        return $this;
    }

    public function setWebhooksOnChannelUpdatedMethod(string $webhooksOnChannelUpdatedMethod): self
    {
        $this->options['webhooksOnChannelUpdatedMethod'] = $webhooksOnChannelUpdatedMethod;
        return $this;
    }

    public function setWebhooksOnMemberAddedUrl(string $webhooksOnMemberAddedUrl): self
    {
        $this->options['webhooksOnMemberAddedUrl'] = $webhooksOnMemberAddedUrl;
        return $this;
    }

    public function setWebhooksOnMemberAddedMethod(string $webhooksOnMemberAddedMethod): self
    {
        $this->options['webhooksOnMemberAddedMethod'] = $webhooksOnMemberAddedMethod;
        return $this;
    }

    public function setWebhooksOnMemberRemovedUrl(string $webhooksOnMemberRemovedUrl): self
    {
        $this->options['webhooksOnMemberRemovedUrl'] = $webhooksOnMemberRemovedUrl;
        return $this;
    }

    public function setWebhooksOnMemberRemovedMethod(string $webhooksOnMemberRemovedMethod): self
    {
        $this->options['webhooksOnMemberRemovedMethod'] = $webhooksOnMemberRemovedMethod;
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

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V1.UpdateServiceOptions ' . $options . ']';
    }
}