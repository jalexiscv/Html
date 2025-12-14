<?php

namespace Twilio\Rest\Notify\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Notify\V1\Service\BindingContext;
use Twilio\Rest\Notify\V1\Service\BindingList;
use Twilio\Rest\Notify\V1\Service\NotificationList;
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
    protected $_bindings;
    protected $_notifications;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($sid) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): ServiceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'ApnCredentialSid' => $options['apnCredentialSid'], 'GcmCredentialSid' => $options['gcmCredentialSid'], 'MessagingServiceSid' => $options['messagingServiceSid'], 'FacebookMessengerPageId' => $options['facebookMessengerPageId'], 'DefaultApnNotificationProtocolVersion' => $options['defaultApnNotificationProtocolVersion'], 'DefaultGcmNotificationProtocolVersion' => $options['defaultGcmNotificationProtocolVersion'], 'FcmCredentialSid' => $options['fcmCredentialSid'], 'DefaultFcmNotificationProtocolVersion' => $options['defaultFcmNotificationProtocolVersion'], 'LogEnabled' => Serialize::booleanToString($options['logEnabled']), 'AlexaSkillId' => $options['alexaSkillId'], 'DefaultAlexaNotificationProtocolVersion' => $options['defaultAlexaNotificationProtocolVersion'], 'DeliveryCallbackUrl' => $options['deliveryCallbackUrl'], 'DeliveryCallbackEnabled' => Serialize::booleanToString($options['deliveryCallbackEnabled']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getBindings(): BindingList
    {
        if (!$this->_bindings) {
            $this->_bindings = new BindingList($this->version, $this->solution['sid']);
        }
        return $this->_bindings;
    }

    protected function getNotifications(): NotificationList
    {
        if (!$this->_notifications) {
            $this->_notifications = new NotificationList($this->version, $this->solution['sid']);
        }
        return $this->_notifications;
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
        return '[Twilio.Notify.V1.ServiceContext ' . implode(' ', $context) . ']';
    }
}