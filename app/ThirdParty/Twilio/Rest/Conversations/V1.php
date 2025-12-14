<?php

namespace Twilio\Rest\Conversations;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Conversations\V1\ConfigurationList;
use Twilio\Rest\Conversations\V1\ConversationContext;
use Twilio\Rest\Conversations\V1\ConversationList;
use Twilio\Rest\Conversations\V1\CredentialContext;
use Twilio\Rest\Conversations\V1\CredentialList;
use Twilio\Rest\Conversations\V1\RoleContext;
use Twilio\Rest\Conversations\V1\RoleList;
use Twilio\Rest\Conversations\V1\ServiceContext;
use Twilio\Rest\Conversations\V1\ServiceList;
use Twilio\Rest\Conversations\V1\UserContext;
use Twilio\Rest\Conversations\V1\UserList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_configuration;
    protected $_conversations;
    protected $_credentials;
    protected $_roles;
    protected $_services;
    protected $_users;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getConfiguration(): ConfigurationList
    {
        if (!$this->_configuration) {
            $this->_configuration = new ConfigurationList($this);
        }
        return $this->_configuration;
    }

    protected function getConversations(): ConversationList
    {
        if (!$this->_conversations) {
            $this->_conversations = new ConversationList($this);
        }
        return $this->_conversations;
    }

    protected function getCredentials(): CredentialList
    {
        if (!$this->_credentials) {
            $this->_credentials = new CredentialList($this);
        }
        return $this->_credentials;
    }

    protected function getRoles(): RoleList
    {
        if (!$this->_roles) {
            $this->_roles = new RoleList($this);
        }
        return $this->_roles;
    }

    protected function getServices(): ServiceList
    {
        if (!$this->_services) {
            $this->_services = new ServiceList($this);
        }
        return $this->_services;
    }

    protected function getUsers(): UserList
    {
        if (!$this->_users) {
            $this->_users = new UserList($this);
        }
        return $this->_users;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.Conversations.V1]';
    }
}