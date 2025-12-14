<?php

namespace Twilio\Rest\Notify\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Notify\V1\Service\BindingList;
use Twilio\Rest\Notify\V1\Service\NotificationList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_bindings;
    protected $_notifications;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'apnCredentialSid' => Values::array_get($payload, 'apn_credential_sid'), 'gcmCredentialSid' => Values::array_get($payload, 'gcm_credential_sid'), 'fcmCredentialSid' => Values::array_get($payload, 'fcm_credential_sid'), 'messagingServiceSid' => Values::array_get($payload, 'messaging_service_sid'), 'facebookMessengerPageId' => Values::array_get($payload, 'facebook_messenger_page_id'), 'defaultApnNotificationProtocolVersion' => Values::array_get($payload, 'default_apn_notification_protocol_version'), 'defaultGcmNotificationProtocolVersion' => Values::array_get($payload, 'default_gcm_notification_protocol_version'), 'defaultFcmNotificationProtocolVersion' => Values::array_get($payload, 'default_fcm_notification_protocol_version'), 'logEnabled' => Values::array_get($payload, 'log_enabled'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'), 'alexaSkillId' => Values::array_get($payload, 'alexa_skill_id'), 'defaultAlexaNotificationProtocolVersion' => Values::array_get($payload, 'default_alexa_notification_protocol_version'), 'deliveryCallbackUrl' => Values::array_get($payload, 'delivery_callback_url'), 'deliveryCallbackEnabled' => Values::array_get($payload, 'delivery_callback_enabled'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getBindings(): BindingList
    {
        return $this->proxy()->bindings;
    }

    protected function getNotifications(): NotificationList
    {
        return $this->proxy()->notifications;
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
        return '[Twilio.Notify.V1.ServiceInstance ' . implode(' ', $context) . ']';
    }
}