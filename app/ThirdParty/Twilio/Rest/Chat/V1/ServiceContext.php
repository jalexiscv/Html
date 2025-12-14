<?php

namespace Twilio\Rest\Chat\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Chat\V1\Service\ChannelContext;
use Twilio\Rest\Chat\V1\Service\ChannelList;
use Twilio\Rest\Chat\V1\Service\RoleContext;
use Twilio\Rest\Chat\V1\Service\RoleList;
use Twilio\Rest\Chat\V1\Service\UserContext;
use Twilio\Rest\Chat\V1\Service\UserList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ServiceContext extends InstanceContext
{
    protected $_channels;
    protected $_roles;
    protected $_users;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($sid) . '';
    }

    public function fetch(): ServiceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DefaultServiceRoleSid' => $options['defaultServiceRoleSid'], 'DefaultChannelRoleSid' => $options['defaultChannelRoleSid'], 'DefaultChannelCreatorRoleSid' => $options['defaultChannelCreatorRoleSid'], 'ReadStatusEnabled' => Serialize::booleanToString($options['readStatusEnabled']), 'ReachabilityEnabled' => Serialize::booleanToString($options['reachabilityEnabled']), 'TypingIndicatorTimeout' => $options['typingIndicatorTimeout'], 'ConsumptionReportInterval' => $options['consumptionReportInterval'], 'Notifications.NewMessage.Enabled' => Serialize::booleanToString($options['notificationsNewMessageEnabled']), 'Notifications.NewMessage.Template' => $options['notificationsNewMessageTemplate'], 'Notifications.AddedToChannel.Enabled' => Serialize::booleanToString($options['notificationsAddedToChannelEnabled']), 'Notifications.AddedToChannel.Template' => $options['notificationsAddedToChannelTemplate'], 'Notifications.RemovedFromChannel.Enabled' => Serialize::booleanToString($options['notificationsRemovedFromChannelEnabled']), 'Notifications.RemovedFromChannel.Template' => $options['notificationsRemovedFromChannelTemplate'], 'Notifications.InvitedToChannel.Enabled' => Serialize::booleanToString($options['notificationsInvitedToChannelEnabled']), 'Notifications.InvitedToChannel.Template' => $options['notificationsInvitedToChannelTemplate'], 'PreWebhookUrl' => $options['preWebhookUrl'], 'PostWebhookUrl' => $options['postWebhookUrl'], 'WebhookMethod' => $options['webhookMethod'], 'WebhookFilters' => Serialize::map($options['webhookFilters'], function ($e) {
            return $e;
        }), 'Webhooks.OnMessageSend.Url' => $options['webhooksOnMessageSendUrl'], 'Webhooks.OnMessageSend.Method' => $options['webhooksOnMessageSendMethod'], 'Webhooks.OnMessageUpdate.Url' => $options['webhooksOnMessageUpdateUrl'], 'Webhooks.OnMessageUpdate.Method' => $options['webhooksOnMessageUpdateMethod'], 'Webhooks.OnMessageRemove.Url' => $options['webhooksOnMessageRemoveUrl'], 'Webhooks.OnMessageRemove.Method' => $options['webhooksOnMessageRemoveMethod'], 'Webhooks.OnChannelAdd.Url' => $options['webhooksOnChannelAddUrl'], 'Webhooks.OnChannelAdd.Method' => $options['webhooksOnChannelAddMethod'], 'Webhooks.OnChannelDestroy.Url' => $options['webhooksOnChannelDestroyUrl'], 'Webhooks.OnChannelDestroy.Method' => $options['webhooksOnChannelDestroyMethod'], 'Webhooks.OnChannelUpdate.Url' => $options['webhooksOnChannelUpdateUrl'], 'Webhooks.OnChannelUpdate.Method' => $options['webhooksOnChannelUpdateMethod'], 'Webhooks.OnMemberAdd.Url' => $options['webhooksOnMemberAddUrl'], 'Webhooks.OnMemberAdd.Method' => $options['webhooksOnMemberAddMethod'], 'Webhooks.OnMemberRemove.Url' => $options['webhooksOnMemberRemoveUrl'], 'Webhooks.OnMemberRemove.Method' => $options['webhooksOnMemberRemoveMethod'], 'Webhooks.OnMessageSent.Url' => $options['webhooksOnMessageSentUrl'], 'Webhooks.OnMessageSent.Method' => $options['webhooksOnMessageSentMethod'], 'Webhooks.OnMessageUpdated.Url' => $options['webhooksOnMessageUpdatedUrl'], 'Webhooks.OnMessageUpdated.Method' => $options['webhooksOnMessageUpdatedMethod'], 'Webhooks.OnMessageRemoved.Url' => $options['webhooksOnMessageRemovedUrl'], 'Webhooks.OnMessageRemoved.Method' => $options['webhooksOnMessageRemovedMethod'], 'Webhooks.OnChannelAdded.Url' => $options['webhooksOnChannelAddedUrl'], 'Webhooks.OnChannelAdded.Method' => $options['webhooksOnChannelAddedMethod'], 'Webhooks.OnChannelDestroyed.Url' => $options['webhooksOnChannelDestroyedUrl'], 'Webhooks.OnChannelDestroyed.Method' => $options['webhooksOnChannelDestroyedMethod'], 'Webhooks.OnChannelUpdated.Url' => $options['webhooksOnChannelUpdatedUrl'], 'Webhooks.OnChannelUpdated.Method' => $options['webhooksOnChannelUpdatedMethod'], 'Webhooks.OnMemberAdded.Url' => $options['webhooksOnMemberAddedUrl'], 'Webhooks.OnMemberAdded.Method' => $options['webhooksOnMemberAddedMethod'], 'Webhooks.OnMemberRemoved.Url' => $options['webhooksOnMemberRemovedUrl'], 'Webhooks.OnMemberRemoved.Method' => $options['webhooksOnMemberRemovedMethod'], 'Limits.ChannelMembers' => $options['limitsChannelMembers'], 'Limits.UserChannels' => $options['limitsUserChannels'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getChannels(): ChannelList
    {
        if (!$this->_channels) {
            $this->_channels = new ChannelList($this->version, $this->solution['sid']);
        }
        return $this->_channels;
    }

    protected function getRoles(): RoleList
    {
        if (!$this->_roles) {
            $this->_roles = new RoleList($this->version, $this->solution['sid']);
        }
        return $this->_roles;
    }

    protected function getUsers(): UserList
    {
        if (!$this->_users) {
            $this->_users = new UserList($this->version, $this->solution['sid']);
        }
        return $this->_users;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Chat.V1.ServiceContext ' . implode(' ', $context) . ']';
    }
}