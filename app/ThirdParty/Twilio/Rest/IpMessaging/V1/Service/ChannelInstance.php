<?php

namespace Twilio\Rest\IpMessaging\V1\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\IpMessaging\V1\Service\Channel\InviteList;
use Twilio\Rest\IpMessaging\V1\Service\Channel\MemberList;
use Twilio\Rest\IpMessaging\V1\Service\Channel\MessageList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ChannelInstance extends InstanceResource
{
    protected $_members;
    protected $_messages;
    protected $_invites;

    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'attributes' => Values::array_get($payload, 'attributes'), 'type' => Values::array_get($payload, 'type'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'createdBy' => Values::array_get($payload, 'created_by'), 'membersCount' => Values::array_get($payload, 'members_count'), 'messagesCount' => Values::array_get($payload, 'messages_count'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ChannelContext
    {
        if (!$this->context) {
            $this->context = new ChannelContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ChannelInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): ChannelInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getMembers(): MemberList
    {
        return $this->proxy()->members;
    }

    protected function getMessages(): MessageList
    {
        return $this->proxy()->messages;
    }

    protected function getInvites(): InviteList
    {
        return $this->proxy()->invites;
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
        return '[Twilio.IpMessaging.V1.ChannelInstance ' . implode(' ', $context) . ']';
    }
}