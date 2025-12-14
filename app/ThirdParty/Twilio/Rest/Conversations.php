<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Conversations\V1;
use Twilio\Rest\Conversations\V1\ConfigurationContext;
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

class Conversations extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://conversations.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getConfiguration(): ConfigurationList
    {
        return $this->v1->configuration;
    }

    protected function contextConfiguration(): ConfigurationContext
    {
        return $this->v1->configuration();
    }

    protected function getConversations(): ConversationList
    {
        return $this->v1->conversations;
    }

    protected function contextConversations(string $sid): ConversationContext
    {
        return $this->v1->conversations($sid);
    }

    protected function getCredentials(): CredentialList
    {
        return $this->v1->credentials;
    }

    protected function contextCredentials(string $sid): CredentialContext
    {
        return $this->v1->credentials($sid);
    }

    protected function getRoles(): RoleList
    {
        return $this->v1->roles;
    }

    protected function contextRoles(string $sid): RoleContext
    {
        return $this->v1->roles($sid);
    }

    protected function getServices(): ServiceList
    {
        return $this->v1->services;
    }

    protected function contextServices(string $sid): ServiceContext
    {
        return $this->v1->services($sid);
    }

    protected function getUsers(): UserList
    {
        return $this->v1->users;
    }

    protected function contextUsers(string $sid): UserContext
    {
        return $this->v1->users($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations]';
    }
}