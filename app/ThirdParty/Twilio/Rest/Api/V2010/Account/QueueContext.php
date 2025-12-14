<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Queue\MemberContext;
use Twilio\Rest\Api\V2010\Account\Queue\MemberList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class QueueContext extends InstanceContext
{
    protected $_members;

    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Queues/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): QueueInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new QueueInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(array $options = []): QueueInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'MaxSize' => $options['maxSize'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new QueueInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getMembers(): MemberList
    {
        if (!$this->_members) {
            $this->_members = new MemberList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_members;
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
        return '[Twilio.Api.V2010.QueueContext ' . implode(' ', $context) . ']';
    }
}