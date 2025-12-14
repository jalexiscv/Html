<?php

namespace Twilio\Rest\Chat\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Chat\V1\Service\Channel\InviteContext;
use Twilio\Rest\Chat\V1\Service\Channel\InviteList;
use Twilio\Rest\Chat\V1\Service\Channel\MemberContext;
use Twilio\Rest\Chat\V1\Service\Channel\MemberList;
use Twilio\Rest\Chat\V1\Service\Channel\MessageContext;
use Twilio\Rest\Chat\V1\Service\Channel\MessageList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ChannelContext extends InstanceContext
{
    protected $_members;
    protected $_messages;
    protected $_invites;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Channels/' . rawurlencode($sid) . '';
    }

    public function fetch(): ChannelInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ChannelInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): ChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'Attributes' => $options['attributes'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ChannelInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    protected function getMembers(): MemberList
    {
        if (!$this->_members) {
            $this->_members = new MemberList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_members;
    }

    protected function getMessages(): MessageList
    {
        if (!$this->_messages) {
            $this->_messages = new MessageList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_messages;
    }

    protected function getInvites(): InviteList
    {
        if (!$this->_invites) {
            $this->_invites = new InviteList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_invites;
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
        return '[Twilio.Chat.V1.ChannelContext ' . implode(' ', $context) . ']';
    }
}