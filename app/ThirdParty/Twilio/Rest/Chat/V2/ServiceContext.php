<?php

namespace Twilio\Rest\Chat\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Chat\V2\Service\BindingContext;
use Twilio\Rest\Chat\V2\Service\BindingList;
use Twilio\Rest\Chat\V2\Service\ChannelContext;
use Twilio\Rest\Chat\V2\Service\ChannelList;
use Twilio\Rest\Chat\V2\Service\RoleContext;
use Twilio\Rest\Chat\V2\Service\RoleList;
use Twilio\Rest\Chat\V2\Service\UserContext;
use Twilio\Rest\Chat\V2\Service\UserList;
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
    protected $_bindings;

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
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DefaultServiceRoleSid' => $options['defaultServiceRoleSid'], 'DefaultChannelRoleSid' => $options['defaultChannelRoleSid'], 'DefaultChannelCreatorRoleSid' => $options['defaultChannelCreatorRoleSid'], 'ReadStatusEnabled' => Serialize::booleanToString($options['readStatusEnabled']), 'ReachabilityEnabled' => Serialize::booleanToString($options['reachabilityEnabled']), 'TypingIndicatorTimeout' => $options['typingIndicatorTimeout'], 'ConsumptionReportInterval' => $options['consumptionReportInterval'], 'Notifications.NewMessage.Enabled' => Serialize::booleanToString($options['notificationsNewMessageEnabled']), 'Notifications.NewMessage.Template' => $options['notificationsNewMessageTemplate'], 'Notifications.NewMessage.Sound' => $options['notificationsNewMessageSound'], 'Notifications.NewMessage.BadgeCountEnabled' => Serialize::booleanToString($options['notificationsNewMessageBadgeCountEnabled']), 'Notifications.AddedToChannel.Enabled' => Serialize::booleanToString($options['notificationsAddedToChannelEnabled']), 'Notifications.AddedToChannel.Template' => $options['notificationsAddedToChannelTemplate'], 'Notifications.AddedToChannel.Sound' => $options['notificationsAddedToChannelSound'], 'Notifications.RemovedFromChannel.Enabled' => Serialize::booleanToString($options['notificationsRemovedFromChannelEnabled']), 'Notifications.RemovedFromChannel.Template' => $options['notificationsRemovedFromChannelTemplate'], 'Notifications.RemovedFromChannel.Sound' => $options['notificationsRemovedFromChannelSound'], 'Notifications.InvitedToChannel.Enabled' => Serialize::booleanToString($options['notificationsInvitedToChannelEnabled']), 'Notifications.InvitedToChannel.Template' => $options['notificationsInvitedToChannelTemplate'], 'Notifications.InvitedToChannel.Sound' => $options['notificationsInvitedToChannelSound'], 'PreWebhookUrl' => $options['preWebhookUrl'], 'PostWebhookUrl' => $options['postWebhookUrl'], 'WebhookMethod' => $options['webhookMethod'], 'WebhookFilters' => Serialize::map($options['webhookFilters'], function ($e) {
            return $e;
        }), 'Limits.ChannelMembers' => $options['limitsChannelMembers'], 'Limits.UserChannels' => $options['limitsUserChannels'], 'Media.CompatibilityMessage' => $options['mediaCompatibilityMessage'], 'PreWebhookRetryCount' => $options['preWebhookRetryCount'], 'PostWebhookRetryCount' => $options['postWebhookRetryCount'], 'Notifications.LogEnabled' => Serialize::booleanToString($options['notificationsLogEnabled']),]);
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

    protected function getBindings(): BindingList
    {
        if (!$this->_bindings) {
            $this->_bindings = new BindingList($this->version, $this->solution['sid']);
        }
        return $this->_bindings;
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
        return '[Twilio.Chat.V2.ServiceContext ' . implode(' ', $context) . ']';
    }
}