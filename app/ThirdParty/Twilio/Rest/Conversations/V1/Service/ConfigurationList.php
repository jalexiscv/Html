<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Conversations\V1\Service\Configuration\NotificationContext;
use Twilio\Rest\Conversations\V1\Service\Configuration\NotificationList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class ConfigurationList extends ListResource
{
    protected $_notifications = null;

    public function __construct(Version $version, string $chatServiceSid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid,];
    }

    protected function getNotifications(): NotificationList
    {
        if (!$this->_notifications) {
            $this->_notifications = new NotificationList($this->version, $this->solution['chatServiceSid']);
        }
        return $this->_notifications;
    }

    public function getContext(): ConfigurationContext
    {
        return new ConfigurationContext($this->version, $this->solution['chatServiceSid']);
    }

    public function __get(string $name)
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
        return '[Twilio.Conversations.V1.ConfigurationList]';
    }
}