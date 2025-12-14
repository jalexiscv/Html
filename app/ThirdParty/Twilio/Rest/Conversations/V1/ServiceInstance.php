<?php

namespace Twilio\Rest\Conversations\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Conversations\V1\Service\BindingList;
use Twilio\Rest\Conversations\V1\Service\ConfigurationList;
use Twilio\Rest\Conversations\V1\Service\ConversationList;
use Twilio\Rest\Conversations\V1\Service\RoleList;
use Twilio\Rest\Conversations\V1\Service\UserList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_conversations;
    protected $_bindings;
    protected $_users;
    protected $_roles;
    protected $_configuration;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'sid' => Values::array_get($payload, 'sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
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

    protected function getConversations(): ConversationList
    {
        return $this->proxy()->conversations;
    }

    protected function getBindings(): BindingList
    {
        return $this->proxy()->bindings;
    }

    protected function getUsers(): UserList
    {
        return $this->proxy()->users;
    }

    protected function getRoles(): RoleList
    {
        return $this->proxy()->roles;
    }

    protected function getConfiguration(): ConfigurationList
    {
        return $this->proxy()->configuration;
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
        return '[Twilio.Conversations.V1.ServiceInstance ' . implode(' ', $context) . ']';
    }
}