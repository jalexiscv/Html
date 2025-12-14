<?php

namespace Twilio\Rest\Chat\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Chat\V1\Service\ChannelList;
use Twilio\Rest\Chat\V1\Service\RoleList;
use Twilio\Rest\Chat\V1\Service\UserList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_channels;
    protected $_roles;
    protected $_users;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'defaultServiceRoleSid' => Values::array_get($payload, 'default_service_role_sid'), 'defaultChannelRoleSid' => Values::array_get($payload, 'default_channel_role_sid'), 'defaultChannelCreatorRoleSid' => Values::array_get($payload, 'default_channel_creator_role_sid'), 'readStatusEnabled' => Values::array_get($payload, 'read_status_enabled'), 'reachabilityEnabled' => Values::array_get($payload, 'reachability_enabled'), 'typingIndicatorTimeout' => Values::array_get($payload, 'typing_indicator_timeout'), 'consumptionReportInterval' => Values::array_get($payload, 'consumption_report_interval'), 'limits' => Values::array_get($payload, 'limits'), 'webhooks' => Values::array_get($payload, 'webhooks'), 'preWebhookUrl' => Values::array_get($payload, 'pre_webhook_url'), 'postWebhookUrl' => Values::array_get($payload, 'post_webhook_url'), 'webhookMethod' => Values::array_get($payload, 'webhook_method'), 'webhookFilters' => Values::array_get($payload, 'webhook_filters'), 'notifications' => Values::array_get($payload, 'notifications'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getChannels(): ChannelList
    {
        return $this->proxy()->channels;
    }

    protected function getRoles(): RoleList
    {
        return $this->proxy()->roles;
    }

    protected function getUsers(): UserList
    {
        return $this->proxy()->users;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Chat.V1.ServiceInstance ' . implode(' ', $context) . ']';
    }
}