<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Conversations\V1\Service\BindingContext;
use Twilio\Rest\Conversations\V1\Service\BindingList;
use Twilio\Rest\Conversations\V1\Service\ConfigurationList;
use Twilio\Rest\Conversations\V1\Service\ConversationList;
use Twilio\Rest\Conversations\V1\Service\RoleList;
use Twilio\Rest\Conversations\V1\Service\UserList;
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
    protected $_conversations;
    protected $_bindings;
    protected $_users;
    protected $_roles;
    protected $_configuration;

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

    protected function getConversations(): ConversationList
    {
        if (!$this->_conversations) {
            $this->_conversations = new ConversationList($this->version, $this->solution['sid']);
        }
        return $this->_conversations;
    }

    protected function getBindings(): BindingList
    {
        if (!$this->_bindings) {
            $this->_bindings = new BindingList($this->version, $this->solution['sid']);
        }
        return $this->_bindings;
    }

    protected function getUsers(): UserList
    {
        if (!$this->_users) {
            $this->_users = new UserList($this->version, $this->solution['sid']);
        }
        return $this->_users;
    }

    protected function getRoles(): RoleList
    {
        if (!$this->_roles) {
            $this->_roles = new RoleList($this->version, $this->solution['sid']);
        }
        return $this->_roles;
    }

    protected function getConfiguration(): ConfigurationList
    {
        if (!$this->_configuration) {
            $this->_configuration = new ConfigurationList($this->version, $this->solution['sid']);
        }
        return $this->_configuration;
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
        return '[Twilio.Conversations.V1.ServiceContext ' . implode(' ', $context) . ']';
    }
}